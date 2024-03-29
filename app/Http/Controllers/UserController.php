<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Roles;
use App\Models\UserRoles;
use App\Models\Guru;
use App\Models\SubKelas;
// use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Utilities\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Queue\Events\Looping;
use Spatie\Permission\Models\Role;
use Symfony\Component\Console\Logger\ConsoleLogger;

// excel
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserImport;

class UserController extends Controller
{
    public function index()
    {
        $data = UserRoles::all();
        $user = User::all();
        $roles = Roles::all();
        return view('dataUser/indexUser',
        [
            'data'=>$data->load('user','role'),
            'user'=>$user,
            "role"=>$roles,
            'count'=>0
        ]);
    }
    public function create()
    {
        return view('dataUser/indexUser');
    }
    
    public function show($dataUser)
    {
        $catch_id = decrypt($dataUser);
        $id = $catch_id;
        $role = Roles::where('id', '!=', 2)->get(); // tidak menampilkan role wali kelas, wali kelas diatur di halaman kelas.
        $user = User::with('role')->where('id', $id)->first();
        $userRole = UserRoles::all()->where('user_id', $id);
        
        $guru = Guru::where('user_id', $id)->first();
        if ($guru != null){
            $sub_kelas = SubKelas::where('guru_id', $guru->id)->first();
            if ($sub_kelas != null){
                $role = Roles::all()->where('id', '!=', 3); // tidak menampilkan role guru, walikelas dapat menjadi admin. Admin dapat menjadi walikelas kembali. Namun tak dapat kembali menjadi guru. Jiak ingin menjadi guru, maka harus udah data kelas terlebih dahulu.
            }
        }
        
        return view('dataUser/showUser',
        [
            'user'=>$user,
            'role'=>$role,
            'userRole'=>$userRole
        ]);
    }
    
    public function storeViaExcel(array $data)
    {
        foreach ($data as $key => $value) {
            $name = $value[1];
            $email = $value[2];
            $user_name = $value[3];
            $securep = bcrypt($value[4]);

            User::create([
                'name'=>$name,
                'email'=>$email,
                'user_name'=>$user_name,
                'password'=>"$securep",
                'created_at'=>now()
            ]);
            
            $new_user_id = User::where('email', $email)->value('id');
            $role_id = Roles::where('role',$value[5])->value('id');
            $userRole=UserRoles::create([
                'user_id'=>$new_user_id,
                'role_id'=>$role_id,
                'created_at'=>now()
            ]);

            if ($role_id == 3){
                Guru::create([
                    'nip'=>null,
                    'nama_guru'=>$name,
                    'created_at'=>now(),
                    'user_id'=>$new_user_id
                ]);
            }
        }
            if ($userRole){
                return response()->json(['success' => 'Data berhasil disimpan!']);
            }
            else {
                return response()->json(['error' => 'Data gagal disimpan!']);
            }
    }
    
    public function store(StoreUserRequest $request)
    {
        $validator=$request->validate([
            'name'=>'required',
            'email'=>'email|unique:user,email',
            'user_name'=>'required|unique:user,user_name',
            'password'=>'required',
            'role_id'=>'required',
        ],
        [
            'name.required'=>'Nama harus diisi',
            'email.email'=>'Isi dengan format email',
            'email.unique'=>'Email sudah digunakan',
            'user_name.required'=>'Username harus diisi',
            'user_name.unique'=>'Username sudah digunakan',
            'password.required'=>'Password harus diisi',
            'role_id.required'=>'Peran harus diisi'
        ]);
        $p=$request->get('password');
        $securep=bcrypt($p);
        User::create([
            'name'=>$request->get('name'),
            'email'=>$request->get('email'),
            'user_name'=>$request->get('user_name'),
            'password'=>"$securep",
            'created_at'=>now()
        ]);
        $new_username = $request->get('user_name');
        $new_user = User::all()->where('user_name', $new_username)->first();
        $new_user_id = $new_user->id;
        $role_ids = $request->get('role_id');
        $userRole=UserRoles::create([
            'user_id'=>$new_user_id,
            'role_id'=>$role_ids,
            'created_at'=>now()
        ]);
        if ($role_ids == 3){
            Guru::create([
                'nip'=>null,
                'nama_guru'=>$request->get('name'),
                'created_at'=>now(),
                'user_id'=>$new_user_id
            ]);
        }
        if ($userRole){
            return response()->json(['success' => 'Data berhasil disimpan!']);
        }
        else {
            return response()->json(['error' => 'Data gagal disimpan!']);
        }
    }
    
    public function update(User $dataUser, UpdateUserRequest $request)
    {
        $validator=$request->validate([
            'name'=>'required',
            'email'=>'email',
        ],
        [
            'name.required'=>'Nama harus diisi',
            'email.email'=>'Isi dengan format email',
        ]);
        
        $role = UserRoles::where('user_id', $dataUser->id)->first();
        
        if($dataUser->id == 1){
            if ($request->get('role') != $role->role_id){
                return response()->json(['error' => 'Gagal mengubah data! Akun master tidak dapat mengubah perannya sendiri!']);
            }
        }
        
        if($dataUser->id == auth()->user()->id){
            if ($request->get('role') != $role->role_id){
                return response()->json(['error' => 'Gagal mengubah data! Anda tidak dapat mengubah peran anda sendiri!']);
            }
        }
        
        if ($request->get('role') != $role->role_id && $request->get('role') != null){
            if ($role->role_id == 2){ //wali kelas
                if ($request->get('role') == 3){ //guru
                    return response()->json(['error' => 'Gagal mengubah data! Wali kelas tidak dapat menjadi guru! Silahkan ubah data guru terlebih dahulu']);
                }
            }
            if ($role->role_id == 1){ //admin
                if ($request->get('role') == 3){ //guru
                    $guru = Guru::where('user_id', $dataUser->id)->first();
                    if ($guru != null){
                        $sub_kelas = SubKelas::where('guru_id', $guru->id)->first();
                        if ($sub_kelas != null){
                            return response()->json(['error' => 'Gagal mengubah data! Admin merupakan wali kelas! Silahkan ubah data wali kelas terlebih dahulu']);
                        }
                    }
                }
            }
            $role->role_id = $request->get('role');
            try {
                $role->save();
            } catch (\Throwable $th) {
                return response()->json(['error' => 'Gagal mengubah data!']);
            }
        }
        
        $dataUser->name = $request->get('name');
        $dataUser->email = $request->get('email');
        
        try {
            $dataUser->save();
            return response()->json(['success' => 'Data berhasil diubah!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Gagal mengubah data!']);
        }
        
    }
    
    public function destroy(User $dataUser)
    {
        $id = $dataUser->id;
        $active_user = auth()->user()->id;
        
        if($id == 1){
            return response()->json(['error' => 'Gagal menghapus data! Akun master tidak dapat dihapus!']);
        }
        
        if($id == $active_user){
            return response()->json(['error' => 'Gagal menghapus data! Anda tidak dapat menghapus akun anda sendiri!']);
        }
        
        $guru = Guru::where('user_id', $id)->first();
        if ($guru != null){
            return response()->json(['error' => 'Gagal menghapus data! Akun ini merupakan akun guru! Silahkan hapus data guru terlebih dahulu']);
        }
        
        try {
            $dataUser->delete();
            return response()->json(['success' => 'Data berhasil dihapus!']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Gagal menghapus data!']);
        }
    }
    
    public function getTable(Request $request){
        if ($request->ajax()) {
            $user = User::all();
            return DataTables::of($user)
            ->addColumn('action', function ($row) {
                $encodedId = encrypt($row->id);
                $btn = '<a href="'. route('dataUser.show', $encodedId) .'" data-toggle="tooltip"  data-id="' . $row . '" data-original-title="Detail" class="btn btn-sm btn-success mx-1 shadow detail"><i class="fas fa-sm fa-fw fa-eye"></i> Detail</a>';
                $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-sm btn-danger mx-1 shadow delete"><i class="fas fa-sm fa-fw fa-trash"></i> Delete</a>';
                
                return $btn;
            })
            ->addColumn('role', function ($row) {
                $role = UserRoles::where('user_id', $row->id)->first();
                $role_name = Roles::where('id', $role->role_id)->first()->role;
                return $role_name;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }
    
    public function export_excel(Request $request)
    {
        $nama_file = 'Data User ' . date('d-m-y') . '.xlsx';
        
        $kode = "FileDataUser";
        $file_identifier = encrypt($kode);
        
        $informasi = [
            'judul' => 'REKAP DATA USER E-RAPOR SDIT IRSYADUL \'IBAD',
            'tanggal' => date('d-m-Y'),
            'file_identifier' => $file_identifier,
        ];
        
        return Excel::download(new UserExport($informasi), $nama_file);
    }
    
    public function import_excel(Request $request)
    {
        $file = $request->file('file_nilai_excel');
        $file_name = $file->getClientOriginalName();
        $kode = "FileDataUser";
        $import = new UserImport($kode);
        Excel::import($import, $file);
        
        if ($import->hasError()) {
            $errors = $import->getMessages();
            return redirect()->back()->with('upload_error', $errors);
        } else {
            $message = $import->getMessages();
            return redirect()->back()->with('upload_success', $message);
        }
    }
}

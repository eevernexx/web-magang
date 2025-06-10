<?php

namespace App\Http\Controllers;

use App\Models\AnakMagang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function account_request_view(){
        $users = User::where('status', 'submitted') ->paginate(10);
        $anak_magangs = AnakMagang::where('user_id', null) ->get();
        return view('pages.account-request.index',[
            'users'=> $users,
            'anak_magangs' => $anak_magangs,
        ]);
    }

    public function account_approval(Request $request, $userId)
    {
        $request->validate([
            'for' => ['required', Rule::in(['approve', 'reject', 'activate', 'deactivate'])]
        ]);
        
        $for = $request->input('for');
        $user = User::findOrFail($userId);
        
        // Set status dan role berdasarkan aksi
        if ($for == 'approve' || $for == 'activate') {
            $user->status = 'approved';
            $user->role_id = 2; // Set role sebagai user biasa
            
            // Buat data anak magang otomatis untuk user yang disetujui
            $anakMagang = new AnakMagang();
            $anakMagang->name = $user->name;
            $anakMagang->asal_sekolah = $user->university;
            $anakMagang->bidang = $user->field_of_study; // Mengambil bidang dari field_of_study user
            $anakMagang->jurusan = $user->field_of_study; // Menggunakan field_of_study sebagai jurusan juga
            $anakMagang->tanggal_masuk = now(); // Menggunakan tanggal saat ini sebagai tanggal masuk
            $anakMagang->tanggal_keluar = now()->addMonths(3); // Tanggal keluar 3 bulan setelah tanggal masuk
            $anakMagang->user_id = $user->id;
            $anakMagang->save();
            
        } else {
            $user->status = 'rejected';
        }
        
        $user->save();

        // Siapkan pesan sukses
        if ($for == 'activate') {
            $message = 'Berhasil mengaktifkan akun';
        } else if ($for == 'deactivate') {
            $message = 'Berhasil menonaktifkan akun';
        } else {
            $message = $for == 'approve' ? 'Berhasil menyetujui akun' : 'Berhasil menolak akun';
        }

        return back()->with('success', $message);
    }

    public function account_list_view(Request $request){    
        $query = User::where('role_id', 2)->where('status','!=','submitted');
        
        // Jika ada parameter pencarian
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', '%'.$searchTerm.'%');
        }
        
        $users = $query->paginate(10);
        $anak_magangs = \App\Models\AnakMagang::whereNull('user_id')->get();
        
        if ($request->ajax()) {
            return response()->json([
                'table_data' => view('pages.account-list.table-data', compact('users', 'anak_magangs'))->render(),
                'pagination' => view('pagination::bootstrap-5', ['paginator' => $users])->render()
            ]);
        }

        return view('pages.account-list.index',[
            'users'=> $users,
            'anak_magangs' => $anak_magangs,
        ]);
    }

    public function profile_view(){
        return view ('pages.profile.index');
    }

    public function update_profile(Request $request, $userId)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'university' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
        ]);

        $user = User::findOrFail($userId);
        
        // Update field basic
        $user->name = $request->input('name');
        $user->university = $request->input('university');
        $user->field_of_study = $request->input('field_of_study');

        // Handle Foto Profil
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && file_exists(public_path('storage/' . $user->profile_picture))) {
                unlink(public_path('storage/' . $user->profile_picture));
            }

            $file = $request->file('profile_picture');
            $filename = $file->store('profile_pictures', 'public');
            $user->profile_picture = $filename;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function change_password_view(){
        return view ('pages.profile.change-password');
    }

    public function change_password(Request $request, $userId){
      
        $request -> validate([
            'old_password' => 'required|min:8',
            'new_password' => 'required|min:8',
        ]);

        $user = User::findOrFail($userId);
        $currentpasswordIsValid = Hash::check($request->input('old_password'), $user->password);

        if($currentpasswordIsValid){
            $user->password = $request->input('new_password');
            $user->save();

            return back()->with('success','Berhasil Mengubah Password');
        }
        
        return back()->with('error','Gagal mengubah password,password lama tidak valid!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validatedData = $request->validate([
            'name' => 'required|string|min:3',
            'university' => 'required|string',
            'field_of_study' => 'required|string',
            'bidang' => 'required|string|in:Pengembangan Komunikasi Publik,Sistem Pemerintahan Berbasis Elektronik,Pengelolaan Informasi Dan Saluran Komunikasi Publik,Pengelolaan Infrastruktur,Statistik,Sekretariat',
        ]);

        // Update data user
        $user->name = $validatedData['name'];
        $user->university = $validatedData['university'];
        $user->field_of_study = $validatedData['field_of_study'];
        $user->bidang = $validatedData['bidang'];
        $user->save();

        // Update data anak magang jika ada
        if ($user->anak_magang) {
            $user->anak_magang->update([
                'name' => $validatedData['name'],
                'asal_sekolah' => $validatedData['university'],
                'jurusan' => $validatedData['field_of_study'],
                'bidang' => $validatedData['bidang']
            ]);
        }

        return redirect()->back()->with('success', 'Data akun berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Hapus relasi dengan anak_magang jika ada
        if ($user->anak_magang) {
            $user->anak_magang->update(['user_id' => null]);
        }
        
        // Hapus foto profil jika ada
        if ($user->profile_picture && file_exists(public_path('storage/' . $user->profile_picture))) {
            unlink(public_path('storage/' . $user->profile_picture));
        }
        
        $user->delete();

        return redirect()->back()->with('success', 'Akun berhasil dihapus');
    }
}

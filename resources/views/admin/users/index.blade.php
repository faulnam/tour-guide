@extends('layouts.admin')

@section('title', 'Manage Administrators')
@section('page_title', 'Administrators & User Accounts')

@section('content')
<div class="space-y-6">
    
    <div class="flex items-center justify-between bg-neutral-900 border border-neutral-800 p-4">
        <div>
            <h2 class="text-xs uppercase tracking-widest font-bold text-white">CMS Administrators</h2>
            <p class="text-[11px] text-neutral-400">Manage user accounts and roles for CMS panel access.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="px-4 py-2.5 bg-white text-black hover:bg-neutral-200 text-xs font-bold uppercase tracking-wider transition-colors">
            + New Admin User
        </a>
    </div>

    <div class="bg-neutral-900 border border-neutral-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-neutral-300">
                <thead class="bg-neutral-950 text-neutral-400 uppercase tracking-wider text-[10px] border-b border-neutral-800">
                    <tr>
                        <th class="py-3.5 px-4">Name</th>
                        <th class="py-3.5 px-4">Email</th>
                        <th class="py-3.5 px-4 text-center">Role</th>
                        <th class="py-3.5 px-4">Registered</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800">
                    @forelse($users as $user)
                        <tr class="hover:bg-neutral-800/50 transition-colors">
                            <td class="py-3 px-4 font-semibold text-white">
                                {{ $user->name }}
                                @if(auth()->id() === $user->id)
                                    <span class="ml-1 text-[9px] bg-neutral-800 text-accent px-1.5 py-0.5 font-bold uppercase">You</span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-neutral-400 font-mono text-[11px]">
                                {{ $user->email }}
                            </td>

                            <td class="py-3 px-4 text-center">
                                <span class="inline-block text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider {{ $user->role === 'super_admin' ? 'bg-amber-950 text-amber-400 border border-amber-800' : 'bg-neutral-800 text-neutral-300' }}">
                                    {{ $user->role }}
                                </span>
                            </td>

                            <td class="py-3 px-4 text-neutral-400">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>

                            <td class="py-3 px-4 text-right space-x-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-neutral-300 hover:text-white font-semibold underline text-[11px]">Edit</a>
                                
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this admin user account?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 text-[11px] underline ml-2">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-neutral-500 text-xs">
                                No admin accounts found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-neutral-800">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

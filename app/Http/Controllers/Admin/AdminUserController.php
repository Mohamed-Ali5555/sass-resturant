<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleName;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\ToggleUserDisabledRequest;
use App\Http\Requests\Admin\User\UpdateUserRolesRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', User::class);

        $q = trim((string) $request->query('q', ''));

        $query = User::query()->with('roles');

        if ($q !== '') {
            $query->where(function ($sub) use ($q): void {
                $sub->where('name', 'like', '%'.$q.'%')
                    ->orWhere('email', 'like', '%'.$q.'%');
            });
        }

        $users = $query->orderByDesc('id')->paginate(25)->withQueryString();

        return view('admin.users.index', compact('users', 'q'));
    }

    public function show(User $user): View
    {
        $this->authorize('view', $user);

        $user->load('roles');

        return view('admin.users.show', [
            'user' => $user,
            'assignableRoles' => [
                RoleName::VendorOwner->value => 'Vendor owner',
                RoleName::Customer->value => 'Customer',
            ],
        ]);
    }

    public function updateRoles(UpdateUserRolesRequest $request, User $user): RedirectResponse
    {
        $user->syncRoles([$request->validated('role')]);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('status', __('Roles updated.'));
    }

    public function toggleDisabled(ToggleUserDisabledRequest $request, User $user): RedirectResponse
    {
        $user->update(['is_disabled' => $request->boolean('is_disabled')]);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('status', __('Account status updated.'));
    }
}

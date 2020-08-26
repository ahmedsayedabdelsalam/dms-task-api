<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportUsersRequest;
use App\Http\Resources\UserIndexResource;
use App\Imports\UsersImport;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function import(ImportUsersRequest $request)
    {
        Excel::queueImport(new UsersImport, $request->file('users_file'));

        return response()->json([
            'message' => 'stay close, while being processing and importing data in the background. :)',
        ]);
    }

    public function index(Request $request)
    {
        return UserIndexResource::collection(
            User::usingRequestQueryBuilder()
                ->accepted()
                ->paginate(request('per_page'))
        )->additional([
            'additional' => [
                'rejected_count' => User::rejected()->count()
            ]
        ]);
    }
}

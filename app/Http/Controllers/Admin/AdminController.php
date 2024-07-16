<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {
    }

    public function index()
    {
        return view('admin.pages.home.admin');
    }

    public function getAllProducers(Request $request)
    {
        $producer = $this->userService->getAllProducers(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->get('filter'),
        );
        dd($producer);
        return view('', [
            'producer' => $producer,
            'items' => $producer->items()
        ]);
    }


}

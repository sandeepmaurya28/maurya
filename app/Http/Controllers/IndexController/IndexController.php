<?php

namespace App\Http\Controllers\IndexController;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
   public function __invoke()
   {
       return view("welcome");
   }
}

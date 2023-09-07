<?php namespace App\Modules\pengisian\analisajabatan\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\pengisian\analisajabatan\Models\AnalisajabatanModel;
use Input,View, Request, Form, File;

class AnalisajabatanController extends Controller {

	/**
	 * Analisajabatan Repository
	 *
	 * @var Analisajabatan
	 */
	protected $analisajabatan;

	public function __construct()
	{
	
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		cekAjax();
		return View::make('analisajabatan::index');
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('analisajabatan::create');
	}
}

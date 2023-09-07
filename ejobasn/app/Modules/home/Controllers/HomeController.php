<?php namespace App\Modules\Home\Controllers;
use App\Http\Controllers\Controller;
use App\Modules\Home\Models\HomeModel;
/**
 * IndexController
 *
 * Controller to house all the functionality directly
 * related to the ModuleOne.
 */
class HomeController extends Controller
{
	function __construct( HomeModel $testModel )
	{
		$this->homeModel = $testModel;
	}
	public function index(){
		return view('Home::index');
	}
	public function usersTest()
	{
		// Added just to demonstrate that models work
		return $this->homeModel->getAny();
	}
}
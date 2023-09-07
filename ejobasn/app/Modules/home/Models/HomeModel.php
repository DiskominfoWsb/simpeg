<?php namespace App\Modules\Home\Models;
use Illuminate\Database\Eloquent\Model;
class HomeModel extends Model
{
	/**
	 * Added just to demonstrate that models work
	 * @return String
	 */
	public function getAny()
	{
		return 'Dummy entry';
	}
}
<?php
/**
 * Created by PhpStorm.
 * User: shawo
 * Date: 10/8/2017
 * Time: 3:30 PM
 */
namespace App\Dao;


use App\Model\CountryModel;
use App\Http\Controllers\Controller;


class CountryDao extends Controller
{
    public function getAll(){

        $countries=CountryModel::all();

        return $countries;
    }

}
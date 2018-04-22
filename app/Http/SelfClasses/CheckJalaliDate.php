<?php
/**
 * Created by PhpStorm.
 * User: Artan
 * Date: 12/10/2017
 * Time: 11:30 AM
 */

namespace App\Http\SelfClasses;



class CheckJalaliDate
{

    public function checkDate($request)
    {
        if(count($request->produce_date) > 0)
        {
            if(preg_match('#^([0-9]?[0-9]?[0-9]{2}[ /.](0?[1-9]|1[012])[ /.](0?[1-9]|[12][0-9]|3[01]))*$#', $request->produce_date))
            {
                if(count($request->expire_date) > 0)
                {
                    if(preg_match('#^([0-9]?[0-9]?[0-9]{2}[ /.](0?[1-9]|1[012])[ /.](0?[1-9]|[12][0-9]|3[01]))*$#', $request->expire_date))
                    {
                        return true;
                    } else
                    {
                        return false;
                    }
                }else
                    {
                        return true;
                    }

            } else
            {
                return false;
            }
        }else
        {
            return true;
        }

    }

}
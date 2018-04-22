<?php
/**
 * Created by PhpStorm.
 * User: Artan
 * Date: 11/28/2017
 * Time: 3:28 PM
 */
namespace App\Http\SelfClasses;
class CheckFiles
{
    public function checkCategoryFiles($request, $type)
    {
        $notAllowedSize = 0;
        $count = count($request->file);
        if (count($request->file) > 0)
        {
            $allowedExtensions = array('png', 'jpg','gif');
            $allowedSize = 10000000;
            $sentExtensions = '';
            $sentSizes = '';
            $i = 0;
            while ($i < $count)
            {
                if (empty($request->file[$i]))
                {
                    $i++;
                }
                $sentExtensions .= '-' . $request->file[$i]->getClientOriginalExtension();
                $sentSizes .= '-' . $request->file[$i]->getClientSize();
                $i++;
            }
            $sentExtensions = substr($sentExtensions, 1);
            $sentExtensionsArray = explode('-', $sentExtensions);
            $extensionArrayDiff = array_diff($sentExtensionsArray, $allowedExtensions);
            if ($extensionArrayDiff == null)
            {
                $sentSizes = substr($sentSizes, 1);
                $sentSizesArray = explode('-', $sentSizes);
                foreach ($sentSizesArray as $item) {
                    if ($item > $allowedSize) {
                        $notAllowedSize++;
                    }
                    if ($notAllowedSize != 0) {
                        return ('سایز فایل یا فایل های انتخاب شده بیش 1 مگابایت است');
                    } else {
                        return $this->checkQuality($request,$type);
                    }
                }

            }
            else
            {
                return ('پسوند فایل یا فایل های انتخاب شده مجاز نمیباشد');
            }

        } else
        {
            return true;
        }
    }

    //below function is related to check if quality is high or not
    public function checkQuality($request,$type)
    {
        $imageWidthHeightErr = 0;
        $count = count($request->file);
        if ($type == 'slider') {
            $imageWidth = 1200;
            $imageHeight = 700;
        } else if ($type == 'logo'){
            $imageWidth = 200;
            $imageHeight = 50;
        }
        else{
            $imageWidth = 300;
            $imageHeight = 250;
        }
        // return true;
        $i = 0;  $image = ['0' => '0' , '1' => '1'];
        $imageName = '';
        while ($i < $count)
        {
            $image = array_merge(getimagesize($request->file[$i]),$image);
            $i++;
        }
        $l = 0;
        $j = 0; $k = 1;
        $newCount = $count-1;
        while($l < $count)
        {
            if ($image[$j] < $imageWidth || $image[$k] < $imageHeight)
            {
                $imageWidthHeightErr++;
                $imageName = '';
                $imageName .= $request->file[$newCount]->getClientOriginalName().'__';
            }
            $k = $k+4;
            $j = $j+4;
            $newCount--;
            $l++;
        }
        if($imageWidthHeightErr != 0)
        {
            return ( ': کیفیت تصویر ذیل نباید کمتر از  ' .$imageWidth. '*' .$imageHeight. 'باشند'."\n". $imageName);
        }
        else
        {
            return true;
        }
    }
}


<?php
namespace App\Traits;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

trait UploadImageTrait{

    public function updateFileOneImage($request, $fieldName, $_dirPath){
        if($request->hasFile($fieldName)){
            $file = $request->$fieldName;
            $fileName_original = $file->getClientOriginalName();
            $extention_file = $file->getClientOriginalExtension();
            $fileName_Filnal = str_replace(".".$extention_file,"_", $fileName_original) .date_format(Carbon::now(),"Y_M_dd_H_m_s").$extention_file;
            $filePath = $request->file($fieldName)->storeAs($_dirPath, $fileName_Filnal);

            $data = [
                'original_name' => $fileName_original,
                'file_path' => Storage::url($filePath),
                'final_name'=>$fileName_Filnal
            ];
            return $data;
        }
        return null;
    }

    public function updateFileMutipleImage( $arrayfile, $_dirPath){
        $data = [];
        foreach ($arrayfile as $file){
            $fileName_original = $file->getClientOriginalName();
            $extention_file = $file->getClientOriginalExtension();
            $fileName_Filnal = str_replace(".".$extention_file,"_", $fileName_original) .date_format(Carbon::now(),"Y_M_dd_H_m_s").$extention_file;
            $filePath = $file->storeAs($_dirPath, $fileName_Filnal);

            $item = [
                'original_name' => $fileName_original,
                'file_path' => Storage::url($filePath),
                'final_name'=>$fileName_Filnal
            ];
            array_push($data,$item) ;

        }

        return $data;
    }
}
?>

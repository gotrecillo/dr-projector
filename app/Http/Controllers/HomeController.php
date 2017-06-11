<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;

class HomeController extends Controller
{

    public function index()
    {

        $files = array_filter(rglob(resource_path('projects/skeleton/') . '*'), 'is_file');

        $replacements = [
            'author_name' => 'Sergio Panadero Perez',
            'author_username' => 'gotrecillo',
            'author_website' => 'gotrecillo.com',
            'author_email' => 'sergio.panadero.perez@gmail.com',
            'vendor' => 'gotrecillo',
            'package_name' => 'php-katas',
            'package_description' => 'Php simple katas',
            'psr4_namespace' => 'Gotrecillo\\PhpKatas'
        ];

        $zip = \Zipper::make('php-katas.zip')->folder('php-katas');

        foreach ($files as $file){
            $fileName = str_replace('/home/gotre/Projects/dr-projector/resources/projects/skeleton/', '', $file);
            $contents =  file_get_contents($file);

            foreach ($replacements as $key => $value) {
                $contents = str_replace("{:{$key}}", $value, $contents);
            }

            $zip->addString($fileName, $contents);
        }

        $zip->close();

        return view('welcome');
    }
}

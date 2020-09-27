<?php
/**
 ** Есть csv-файл, в котором хранятся данные о новом классификаторе заболеваний.
 ** Его нужно было загрузить в базу, учитывая связи 4х таблиц.
*/

// Парсер для добавления классификаторов ОЛК. Start
use App\Complexservice;
use App\Servicecategory;
use App\Services;

$fileCsv = "C:\Users\aan\Desktop\KODMSK2018.1_OF090219-test4.csv";
function categoriesToBase($fileCsv)
{
    $handle = fopen($fileCsv, "r");
    while (($row = fgetcsv($handle, 100000, ";")) !== FALSE) {
        $matrix[] = $row;
    }
    foreach ($matrix as $keys => $values) {
        foreach ($values as $key => $val) {
            print_r("[{$key}] => $val<br>");
        }
        echo "<br>";
    }
    $parentIdCons = Servicecategory::find(1039);
    $parentIdLaz = Servicecategory::find(1040);
    $parentIdHir = Servicecategory::find(1041);
//$serviceCategoryParent = 'Лазерное лечение';
    $idServiceCategoryParent = 1040;
    foreach ($matrix as $key => $value) {
        $matches = Servicecategory::where([['id', '>', 1041], ['title', '=', $value[1]]])->orderBy('id', 'desc')->get();
        $matchesCategory = Servicecategory::where([['id', '>', 1041], ['title', '=', $value[1]], ['parent_id', '=',
            $idServiceCategoryParent]])->orderBy('id', 'desc')->get();
        $serviceCategory = Servicecategory::where([['id', '>', 1041], ['title', '=', $value[1]]])->pluck('id');
        if(!count($matches)){
            if ($value[0] === 'Консервативное лечение') {
                $serviceCategory = Servicecategory::create([
                    'title' => $value[1]
                ], $parentIdCons);
//$serviceCategoryParent = $value[0];
                $idServiceCategoryParent = 1039;
            } elseif ($value[0] === 'Лазерное лечение') {
                $serviceCategory = Servicecategory::create([
                    'title' => $value[1]
                ], $parentIdLaz);
//$serviceCategoryParent = $value[0];
                $idServiceCategoryParent = 1040;
            } elseif ($value[0] === 'Хирургическое лечение') {
                $serviceCategory = Servicecategory::create([
                    'title' => $value[1]
                ], $parentIdHir);
//$serviceCategoryParent = $value[0];
                $idServiceCategoryParent = 1041;
            }
        } elseif (!count($matchesCategory)){
            if ($value[0] === 'Консервативное лечение') {
                $serviceCategory = Servicecategory::create([
                    'title' => $value[1]
                ], $parentIdCons);
//$serviceCategoryParent = $value[0];
                $idServiceCategoryParent = 1039;
            } elseif ($value[0] === 'Лазерное лечение') {
                $serviceCategory = Servicecategory::create([
                    'title' => $value[1]
                ], $parentIdLaz);
//$serviceCategoryParent = $value[0];
                $idServiceCategoryParent = 1040;
            } elseif ($value[0] === 'Хирургическое лечение') {
                $serviceCategory = Servicecategory::create([
                    'title' => $value[1]
                ], $parentIdHir);
//$serviceCategoryParent = $value[0];
                $idServiceCategoryParent = 1041;
            }
        }
        $idCategory = Servicecategory::where([['id', '>', 1041], ['title', '=', $value[1]], ['parent_id', '=',
            $idServiceCategoryParent]])->pluck('id');
        $idServiceCategory = $idCategory[0];
        $complexservice = Complexservice::create([
            'code_mntk' => $value[2],
            'kopmskmy' => $value[3],
            'short_name' => $value[5],
            'cost' => $value[13],
            'cost_nds' => $value[13],
            'title' => $value[4],
            'servicecategory_id' => $idServiceCategory,
            'code' => $value[10],
            'code_type_anest' => $value[6],
            'code_type_olk' => $value[7],
            'kind_olk' => $value[8],
            'difficulty_olk' => $value[9],
            'code_oms' => $value[10],
            'name_oms' => $value[11],
            'ksg' => $value[12],
            'tarif' => $value[13],
            'tarifkratkosrochnuy' => $value[14],
            'tarif2glaz' => $value[15],
            'ksgds' => $value[16],
            'tards' => $value[17],
            'tarif_ksgds' => $value[18],
            'dog2' => $value[19],
            'idhmp' => $value[20],
            'hmname' => $value[21],
            'hvid' => $value[22],
            'mkb' => $value[23],
            'tarif2' => $value[24],
            'tarif_pd' => $value[25] . '.00',
            'tarif_pd_112018' => $value[26],
            'kat2004' => $value[27],
            'islinza' => $value[28],
            'kop' => $value[29],
            'k1' => $value[30],
            's2004' => $value[31],
            'razd2004' => $value[32],
            'class' => $value[33],
            'kind' => $value[34],
            'code2' => $value[35],
            'kopornmsk' => $value[38],
            'gr' => $value[39],
            'diag_code' => $value[40],
            'difficulty' => $value[41],
            'difficulty_s' => $value[42],
            'difficulty_1' => $value[43],
            'difficulty_2' => $value[44],
            'difficulty_3' => $value[45],
            'typeservice_id' => 3,
        ]);
        $services = Services::create([
            'typeservice_id' => 3,
            'title' => $value[4],
            'preparatsets_id' => 0,
        ]);
        $idService = $services->id;
        $complexservice->services()->attach($idService, ['weight' => 0, 'mandatory' => 1]);
    }
}
//categoriesToBase($fileCsv);
//print_r(categoriesToBase($fileCsv));
//exit();
// Парсер для добавления классификаторов ОЛК. End
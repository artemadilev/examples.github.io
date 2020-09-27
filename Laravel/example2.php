<?php
/** Вывод статистики по Катаракте(любой), с остротой зрения = 0,3 (с коррекцией) и ниже.
** Заказчику потребовалась статистика по конкретному заболеванию с условием.
** Комментарии в коде есть, в итоге получили количество пациентов с учетом заданных условий.
 */

use App\Inspections;
use App\Ostrotavochkah;
use App\Research;

$diagnozes = range(125,138);
array_push($diagnozes, 144, 145, 146, 147, 306, 337, 348, 478, 479); // добавляем все диагнозы, связанные с катарактой
// Находим пациентов у которых в правом или левом глазу встречается катаракта (без дублей)
$katarakta = Inspections::whereIn('diagnozes_id', $diagnozes)->orWhereIn('os_diagnozes_id', $diagnozes)->get();
$log = $katarakta->unique('patients_id');
$log = $log->values();
// Создаем массив с id’шниками найденных пациентов
$patientsIDArr = [];
foreach ($log as $item) {
    array_push($patientsIDArr, $item->patients_id);
}
// Находим все исследования для этих пациентов
$researchID = Research::whereIn('patients_id', $patientsIDArr)->get();
$researchIDArr = [];
foreach ($researchID as $item) {
    array_push($researchIDArr, $item->id);
}
// Находим исследования Визометрия с указанной остротой зрения
$vizo = Ostrotavochkah::where('ozbk_od', '<', 6)->orWhere('ozbk_os', '<', 6)->get();
$vizoArr = [];
foreach ($vizo as $item) {
    if (in_array($item->research_id, $researchIDArr)) {
        array_push($vizoArr, $item->id);
    }
}
// Выводим полученные данные
dd($vizoArr);
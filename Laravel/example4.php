<?php

/**
 * Добавление метода updateplan, который получает данные по обновленным статусам местам в палатах.
 * Обновляет записи в базе.
 */

public function updateplan(Request $request)
{
    $fields = $request->all();
    foreach ($fields['roomsUpdate'] as $key => $item) {
        $places = Place::where('room_id', '=', $key)->get();
        for ($i = 0; $i < count($places); $i++) {
            if (($i + 1) <= $item) {
                $places[$i]->update([
                    'is_available' => 1 // Место доступно для размещения
                ]);
            } else {
                $places[$i]->update([
                    'is_available' => 0 // Место недоступно для размещения
                ]);
            }
        }
    }
    return redirect()->route(config('quickadmin.route') . '.habitation.index');
}
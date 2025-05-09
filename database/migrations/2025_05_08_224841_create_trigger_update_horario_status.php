<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

class CreateTriggerUpdateHorarioStatus extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER update_horario_status_after_delete_agenda
            AFTER DELETE ON agenda
            FOR EACH ROW
            BEGIN
                DECLARE agendamentos_count INT;

                SELECT COUNT(*) INTO agendamentos_count
                FROM agenda
                WHERE horario_id = OLD.horario_id;

                IF agendamentos_count = 0 THEN
                    UPDATE horario
                    SET status = "disponivel"
                    WHERE id = OLD.horario_id;
                END IF;
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS update_horario_status_after_delete_agenda');
    }
}

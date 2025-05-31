<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddTriggersToTables extends Migration
{
    public function up()
    {
        // 1. AFTER UPDATE mantenimiento
        DB::unprepared("CREATE TRIGGER after_mantenimiento_update AFTER UPDATE ON mantenimiento FOR EACH ROW BEGIN
            IF NEW.estado != OLD.estado THEN
                IF NEW.estado = 'en_proceso' THEN
                    UPDATE consola SET estado = 'mantenimiento' WHERE id = NEW.id_consola;
                ELSEIF (OLD.estado = 'en_proceso' AND NEW.estado IN ('completado', 'cancelado')) THEN
                    UPDATE consola SET estado = 'disponible' WHERE id = NEW.id_consola;
                END IF;
            END IF;
        END;");

        // 2. BEFORE INSERT mantenimiento
        DB::unprepared("CREATE TRIGGER before_mantenimiento_insert BEFORE INSERT ON mantenimiento FOR EACH ROW BEGIN
            DECLARE mantenimiento_activo INT DEFAULT 0;
            IF NEW.estado = 'en_proceso' THEN
                SELECT COUNT(*) INTO mantenimiento_activo FROM mantenimiento WHERE id_consola = NEW.id_consola AND estado = 'en_proceso';
                IF mantenimiento_activo > 0 THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No se puede tener más de un mantenimiento en proceso por consola';
                END IF;
            END IF;
        END;");

        // 3. BEFORE UPDATE mantenimiento
        DB::unprepared("CREATE TRIGGER before_mantenimiento_update BEFORE UPDATE ON mantenimiento FOR EACH ROW BEGIN
            DECLARE mantenimiento_activo INT DEFAULT 0;
            IF NEW.estado = 'en_proceso' AND OLD.estado != 'en_proceso' THEN
                SELECT COUNT(*) INTO mantenimiento_activo FROM mantenimiento WHERE id_consola = NEW.id_consola AND estado = 'en_proceso' AND id != NEW.id;
                IF mantenimiento_activo > 0 THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No se puede tener más de un mantenimiento en proceso por consola';
                END IF;
            END IF;
        END;");

        // 4. AFTER INSERT prestamo
        DB::unprepared("CREATE TRIGGER after_insert_prestamo AFTER INSERT ON prestamo FOR EACH ROW BEGIN
            DECLARE minutos INT;
            DECLARE precio INT;
            DECLARE tipoConsola VARCHAR(10);

            -- Obtener el tipo de consola
            SELECT tipo INTO tipoConsola FROM consola WHERE id = NEW.id_consola;

            -- Convertir tiempo de uso a número
            SET minutos = CAST(NEW.tiempodeuso AS UNSIGNED);

            -- Determinar el precio según el tipo de consola y tiempo de uso
            IF tipoConsola = '360' THEN
                CASE 
                    WHEN minutos <= 30 THEN SET precio = 1500;
                    WHEN minutos <= 60 THEN SET precio = 2500;
                    WHEN minutos <= 90 THEN SET precio = 3000;
                    WHEN minutos <= 120 THEN SET precio = 5000;
                    WHEN minutos <= 180 THEN SET precio = 7500;
                    ELSE 
                        SET precio = (FLOOR(minutos / 180) * 7500) + 
                                     CASE 
                                         WHEN minutos % 180 <= 30 THEN 1500
                                         WHEN minutos % 180 <= 60 THEN 2500
                                         WHEN minutos % 180 <= 90 THEN 3000
                                         WHEN minutos % 180 <= 120 THEN 5000
                                         ELSE 7500
                                     END;
                END CASE;
            ELSEIF tipoConsola = 'one' THEN
                CASE 
                    WHEN minutos <= 30 THEN SET precio = 1500;
                    WHEN minutos <= 60 THEN SET precio = 3000;
                    WHEN minutos <= 90 THEN SET precio = 3500;
                    WHEN minutos <= 120 THEN SET precio = 5500;
                    WHEN minutos <= 180 THEN SET precio = 8500;
                    ELSE 
                        SET precio = (FLOOR(minutos / 180) * 8500) + 
                                     CASE 
                                         WHEN minutos % 180 <= 30 THEN 1500
                                         WHEN minutos % 180 <= 60 THEN 3000
                                         WHEN minutos % 180 <= 90 THEN 3500
                                         WHEN minutos % 180 <= 120 THEN 5500
                                         ELSE 8500
                                     END;
                END CASE;
            ELSE
                SET precio = 0; -- Si el tipo de consola no coincide
            END IF;

            -- Insertar el registro en la tabla venta con la fecha del préstamo
            INSERT INTO venta (id_prestamo, fecha, monto)
            VALUES (NEW.idPrestamo, NEW.fecha, precio);
        END;");
    }

    public function down()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS after_mantenimiento_update;");
        DB::unprepared("DROP TRIGGER IF EXISTS before_mantenimiento_insert;");
        DB::unprepared("DROP TRIGGER IF EXISTS before_mantenimiento_update;");
        DB::unprepared("DROP TRIGGER IF EXISTS after_insert_prestamo;");
    }
}
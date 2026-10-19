<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
//--------------------------------================== Funciones busqueda de recetas =====================------------------------------------------------ 
    DB::unprepared("CREATE OR REPLACE FUNCTION BR_N(varchar) RETURNS TABLE(cod_receta bigint, nombre_receta varchar, descripcion varchar, instrucciones varchar, cantidad_personas smallint, categoria varchar, regimen_alimenticio varchar, id_usuario bigint) AS $$
                    DECLARE
                        nombre_busqueda ALIAS FOR $1;
                        recetas CURSOR FOR (SELECT * FROM receta);
                        fila_cursor RECORD;
                    BEGIN
                        OPEN recetas; 
                        LOOP
                            FETCH recetas INTO fila_cursor;
                            EXIT WHEN NOT FOUND; 
                            IF(fila_cursor.nombre_receta = nombre_busqueda) THEN
                                cod_receta = fila_cursor.cod_receta;
                                nombre_receta = fila_cursor.nombre_receta;
                                descripcion = fila_cursor.descripcion;
                                instrucciones = fila_cursor.instrucciones;
                                cantidad_personas = fila_cursor.cantidad_personas;
                                categoria = fila_cursor.categoria;
                                regimen_alimenticio = fila_cursor.regimen_alimenticio;
                                id_usuario = fila_cursor.id_usuario;
                                RETURN NEXT; 
                            END IF;
                        END LOOP; 
                        CLOSE recetas; 
                        RETURN; 
                    END; $$ LANGUAGE 'plpgsql';");

    DB::unprepared("CREATE OR REPLACE FUNCTION BR_NyC(varchar, varchar) RETURNS TABLE(cod_receta bigint, nombre_receta varchar, descripcion varchar, instrucciones varchar, cantidad_personas smallint, categoria varchar, regimen_alimenticio varchar, id_usuario bigint) AS $$
                    DECLARE
                        nombre_busqueda ALIAS FOR $1;
                        categoria_busqueda ALIAS FOR $2;

                        recetas CURSOR FOR (SELECT * FROM receta);
                        fila_cursor RECORD;
                    BEGIN
                        OPEN recetas; 
                        LOOP
                            FETCH recetas INTO fila_cursor;
                            EXIT WHEN NOT FOUND; 
                            
                            IF((fila_cursor.nombre_receta = nombre_busqueda) AND (fila_cursor.categoria = categoria_busqueda)) THEN

                                cod_receta = fila_cursor.cod_receta;
                                nombre_receta = fila_cursor.nombre_receta;
                                descripcion = fila_cursor.descripcion;
                                instrucciones = fila_cursor.instrucciones;
                                cantidad_personas = fila_cursor.cantidad_personas;
                                categoria = fila_cursor.categoria;
                                regimen_alimenticio = fila_cursor.regimen_alimenticio;
                                id_usuario = fila_cursor.id_usuario;

                                RETURN NEXT; 
                            END IF;
                        END LOOP; 

                        CLOSE recetas; 
                        RETURN; 
                    END; $$ LANGUAGE 'plpgsql'; ");
    
    DB::unprepared("CREATE OR REPLACE FUNCTION BR_NyR(varchar, varchar) RETURNS TABLE(cod_receta bigint, nombre_receta varchar, descripcion varchar, instrucciones varchar, cantidad_personas smallint, categoria varchar, regimen_alimenticio varchar, id_usuario bigint) AS $$
                    DECLARE
                        nombre_busqueda ALIAS FOR $1;
                        regimen_alimenticio_busqueda ALIAS FOR $2;

                        recetas CURSOR FOR (SELECT * FROM receta);
                        fila_cursor RECORD;
                    BEGIN
                        OPEN recetas; 
                        LOOP
                            FETCH recetas INTO fila_cursor;
                            EXIT WHEN NOT FOUND; 
                            
                            IF((fila_cursor.nombre_receta = nombre_busqueda) AND (fila_cursor.regimen_alimenticio = regimen_alimenticio_busqueda)) THEN

                                cod_receta = fila_cursor.cod_receta;
                                nombre_receta = fila_cursor.nombre_receta;
                                descripcion = fila_cursor.descripcion;
                                instrucciones = fila_cursor.instrucciones;
                                cantidad_personas = fila_cursor.cantidad_personas;
                                categoria = fila_cursor.categoria;
                                regimen_alimenticio = fila_cursor.regimen_alimenticio;
                                id_usuario = fila_cursor.id_usuario;

                                RETURN NEXT; 
                            END IF;
                        END LOOP; 

                        CLOSE recetas; 
                        RETURN; 
                    END; $$ LANGUAGE 'plpgsql'; ");
    
    DB::unprepared("CREATE OR REPLACE FUNCTION BR_NyRyC(varchar, varchar, varchar) RETURNS TABLE(cod_receta bigint, nombre_receta varchar, descripcion varchar, instrucciones varchar, cantidad_personas smallint, categoria varchar, regimen_alimenticio varchar, id_usuario bigint) AS $$
                    DECLARE
                        nombre_busqueda ALIAS FOR $1;
                        regimen_alimenticio_busqueda ALIAS FOR $2;
                        categoria_busqueda ALIAS FOR $3;

                        recetas CURSOR FOR (SELECT * FROM receta);
                        fila_cursor RECORD;
                    BEGIN
                        OPEN recetas; 
                        LOOP
                            FETCH recetas INTO fila_cursor;
                            EXIT WHEN NOT FOUND; 
                            
                            IF((fila_cursor.nombre_receta = nombre_busqueda) AND (fila_cursor.regimen_alimenticio = regimen_alimenticio_busqueda) AND (fila_cursor.categoria = categoria_busqueda)) THEN

                                cod_receta = fila_cursor.cod_receta;
                                nombre_receta = fila_cursor.nombre_receta;
                                descripcion = fila_cursor.descripcion;
                                instrucciones = fila_cursor.instrucciones;
                                cantidad_personas = fila_cursor.cantidad_personas;
                                categoria = fila_cursor.categoria;
                                regimen_alimenticio = fila_cursor.regimen_alimenticio;
                                id_usuario = fila_cursor.id_usuario;

                                RETURN NEXT; 
                            END IF;
                        END LOOP; 

                        CLOSE recetas; 
                        RETURN; 
                    END; $$ LANGUAGE 'plpgsql'; ");
//--------------------------------================== Funciones busqueda de ingrediente =====================------------------------------------------------
    DB::unprepared("CREATE OR REPLACE FUNCTION BI_NyRyC(varchar, varchar, varchar) RETURNS TABLE(cod_receta bigint, nombre varchar, cantidad_ingrediente NUMERIC(5, 2), unidad_medida varchar) AS $$
                    DECLARE
                        nombre_busqueda ALIAS FOR $1;
                        regimen_alimenticio_busqueda ALIAS FOR $2;
                        categoria_busqueda ALIAS FOR $3;

                        ingredientes CURSOR FOR (SELECT r.cod_receta, r.nombre_receta, r.categoria, r.regimen_alimenticio, i.nombre, c.cantidad_ingrediente, c.unidad_medida     
                                                FROM receta r, contiene c, ingrediente i
                                                WHERE r.cod_receta = c.cod_receta 
                                                    AND c.cod_ingrediente = i.cod_ingrediente); 
                        fila_cursor RECORD; 
                    BEGIN 
                        OPEN ingredientes; 
                        LOOP
                            FETCH ingredientes INTO fila_cursor;
                            EXIT WHEN NOT FOUND;
                            IF((fila_cursor.nombre_receta = nombre_busqueda) AND (fila_cursor.regimen_alimenticio = regimen_alimenticio_busqueda) AND (fila_cursor.categoria = categoria_busqueda)) THEN
                                cod_receta = fila_cursor.cod_receta;
                                nombre = fila_cursor.nombre;
                                cantidad_ingrediente = fila_cursor.cantidad_ingrediente; 
                                unidad_medida = fila_cursor.unidad_medida;

                                RETURN NEXT; 
                            END IF; 
                        END LOOP; 	
                        
                        CLOSE ingredientes;
                        RETURN; 
                    END; $$ LANGUAGE 'plpgsql';");

    DB::unprepared("CREATE OR REPLACE FUNCTION BI_NyR(varchar, varchar) RETURNS TABLE(cod_receta bigint, nombre varchar, cantidad_ingrediente NUMERIC(5, 2), unidad_medida varchar) AS $$
                    DECLARE
                        nombre_busqueda ALIAS FOR $1;
                        regimen_alimenticio_busqueda ALIAS FOR $2;

                        ingredientes CURSOR FOR (SELECT r.cod_receta, r.nombre_receta, r.categoria, r.regimen_alimenticio, i.nombre, c.cantidad_ingrediente, c.unidad_medida     
                                                FROM receta r, contiene c, ingrediente i
                                                WHERE r.cod_receta = c.cod_receta 
                                                    AND c.cod_ingrediente = i.cod_ingrediente); 
                        fila_cursor RECORD; 
                    BEGIN 
                        OPEN ingredientes; 
                        LOOP
                            FETCH ingredientes INTO fila_cursor;
                            EXIT WHEN NOT FOUND;
                            IF((fila_cursor.nombre_receta = nombre_busqueda) AND (fila_cursor.regimen_alimenticio = regimen_alimenticio_busqueda)) THEN
                                cod_receta = fila_cursor.cod_receta;
                                nombre = fila_cursor.nombre;
                                cantidad_ingrediente = fila_cursor.cantidad_ingrediente; 
                                unidad_medida = fila_cursor.unidad_medida;

                                RETURN NEXT; 
                            END IF; 
                        END LOOP; 	
                        
                        CLOSE ingredientes;
                        RETURN; 
                    END; $$ LANGUAGE 'plpgsql';");
        
    DB::unprepared("CREATE OR REPLACE FUNCTION BI_NyC(varchar, varchar) RETURNS TABLE(cod_receta bigint, nombre varchar, cantidad_ingrediente NUMERIC(5, 2), unidad_medida varchar) AS $$
                    DECLARE
                        nombre_busqueda ALIAS FOR $1;
                        categoria_busqueda ALIAS FOR $2;

                        ingredientes CURSOR FOR (SELECT r.cod_receta, r.nombre_receta, r.categoria, r.regimen_alimenticio, i.nombre, c.cantidad_ingrediente, c.unidad_medida     
                                                FROM receta r, contiene c, ingrediente i
                                                WHERE r.cod_receta = c.cod_receta 
                                                    AND c.cod_ingrediente = i.cod_ingrediente); 
                        fila_cursor RECORD; 
                    BEGIN 
                        OPEN ingredientes; 
                        LOOP
                            FETCH ingredientes INTO fila_cursor;
                            EXIT WHEN NOT FOUND;
                            IF((fila_cursor.nombre_receta = nombre_busqueda) AND (fila_cursor.categoria = categoria_busqueda)) THEN
                                cod_receta = fila_cursor.cod_receta;
                                nombre = fila_cursor.nombre;
                                cantidad_ingrediente = fila_cursor.cantidad_ingrediente; 
                                unidad_medida = fila_cursor.unidad_medida;

                                RETURN NEXT; 
                            END IF; 
                        END LOOP; 	
                        
                        CLOSE ingredientes;
                        RETURN; 
                    END; $$ LANGUAGE 'plpgsql';");

    DB::unprepared("CREATE OR REPLACE FUNCTION BI_N(varchar) RETURNS TABLE(cod_receta bigint, nombre varchar, cantidad_ingrediente NUMERIC(5, 2), unidad_medida varchar) AS $$
                    DECLARE
                        nombre_busqueda ALIAS FOR $1;

                        ingredientes CURSOR FOR (SELECT r.cod_receta, r.nombre_receta, r.categoria, r.regimen_alimenticio, i.nombre, c.cantidad_ingrediente, c.unidad_medida     
                                                FROM receta r, contiene c, ingrediente i
                                                    WHERE r.cod_receta = c.cod_receta 
                                                    AND c.cod_ingrediente = i.cod_ingrediente); 
                        fila_cursor RECORD; 
                    BEGIN 
                        OPEN ingredientes; 
                        LOOP
                            FETCH ingredientes INTO fila_cursor;
                            EXIT WHEN NOT FOUND;
                            IF(fila_cursor.nombre_receta = nombre_busqueda) THEN
                                cod_receta = fila_cursor.cod_receta;
                                nombre = fila_cursor.nombre;
                                cantidad_ingrediente = fila_cursor.cantidad_ingrediente; 
                                unidad_medida = fila_cursor.unidad_medida;

                                RETURN NEXT; 
                            END IF; 
                        END LOOP; 	
                        
                        CLOSE ingredientes;
                        RETURN; 
                    END; $$ LANGUAGE 'plpgsql';");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    //Delete para funcion buscar receta.
        DB::statement("DROP FUNCTION public.br_n(varchar);");
        DB::statement("DROP FUNCTION public.br_nyc(varchar, varchar);");
        DB::statement("DROP FUNCTION public.br_nyr(varchar, varchar);");
        DB::statement("DROP FUNCTION public.br_nyryc(varchar, varchar, varchar);"); 
    //Delete para funcion buscar ingrediente.
        DB::statement("DROP FUNCTION public.bi_nyryc(varchar, varchar, varchar);");
        DB::statement("DROP FUNCTION public.bi_nyr(varchar, varchar);");
        DB::statement("DROP FUNCTION public.bi_nyc(varchar, varchar);");
        DB::statement("DROP FUNCTION public.bi_n(varchar);");
    }
};

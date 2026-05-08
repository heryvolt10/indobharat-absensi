DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_periode`(IN `in_tanggal` DATE, IN `in_periode` VARCHAR(2), IN `in_tipe` INT)
BEGIN

    SET @tanggal = in_tanggal;
    SET @periode = in_periode;
    SET @tipe = in_tipe;

    SET @tanggal_mulai = (SELECT IFNULL(tanggal_mulai,0) as tanggal_mulai FROM mt_periode WHERE f_status = 2 AND tanggal <= @tanggal ORDER BY tanggal DESC LIMIT 1);

    SET @DateMulaiLastYear = (CONCAT(YEAR(@tanggal), '-12-', @tanggal_mulai));
    SET @LastYear = (CONCAT(YEAR(@tanggal), '-12-31'));

    IF ((DATE(@tanggal) >= DATE(@DateMulaiLastYear)) AND (DATE(@tanggal) <= DATE(@LastYear))) THEN 
        SET @tahunperiode = ((YEAR(@tanggal)) + 1);
    ELSE
        SET @tahunperiode = YEAR(@tanggal);
    END IF;
    
    SET @tahun = @tahunperiode;

    CREATE TEMPORARY TABLE IF NOT EXISTS tb_list_yearperiod (
        id int AUTO_INCREMENT PRIMARY KEY,
        tahun int,
        periode int,
        dari date,
        sampai date
    );

        SET @bulan = 12;
        SET @count = 1;
        SET @row_num := 0;

        WHILE @bulan >= @count DO

        IF (@tanggal_mulai = 1) THEN
            INSERT INTO tb_list_yearperiod
            SELECT (@row_num := @row_num + 1) as id, @tahun as tahun, X.periode, X.dari, LAST_DAY(X.dari) as sampai
            FROM (
                SELECT @count as periode, CONCAT(@tahun, '-', @count, '-', @tanggal_mulai) as dari
            ) X;
        ELSE 
            IF (@count = 1) THEN
                INSERT INTO tb_list_yearperiod
                SELECT  (@row_num := @row_num + 1) as id, @tahun as tahun, @count as periode, CONCAT((@tahun - 1), '-', '12', '-', @tanggal_mulai) as dari, 
                CONCAT(@tahun, '-', @count, '-', (@tanggal_mulai - 1)) as sampai
                ;
            ELSE 
                    INSERT INTO tb_list_yearperiod
                    SELECT (@row_num := @row_num + 1) as id, @tahun as tahun, @count as periode, CONCAT(@tahun, '-', (@count - 1), '-', @tanggal_mulai) as dari, 
                    CONCAT(@tahun, '-', @count, '-', (@tanggal_mulai - 1)) as sampai
                    ;
            
                
            END IF;
            
        END IF;

        SET @count =  @count + 1;        
        END WHILE;
        
        /*TIPE kosong - Untuk memunculkan semua list periode*/
        /*TIPE 1 - Untuk mencari rentang tanggal*/
        /*TIPE 2 - Untuk mencari tahun dan period*/
        /*TIPE 3 - Untuk mencari Minimal dan Maksimal Tanggal */
        /*TIPE 100 - UNTUK KEPERLUAN LIST TANPA DROP TABLE*/
        
        
        IF (@tipe = '1') THEN
            SELECT * FROM tb_list_yearperiod
            WHERE (@tanggal >= dari AND @tanggal <= sampai )
            ;
            DROP TEMPORARY TABLE tb_list_yearperiod;
        ELSEIF (@tipe = '2') THEN 
            SELECT * FROM tb_list_yearperiod
            WHERE periode = @periode AND tahun = @tahun 
            ;
            DROP TEMPORARY TABLE tb_list_yearperiod;
        ELSEIF (@tipe = '3') THEN 
            SET @tanggalMin =  (SELECT MIN(dari) as dariMin FROM tb_list_yearperiod);
            SET @tanggalMax =  (SELECT MAX(sampai) as sampaiMax FROM tb_list_yearperiod);
            
            SELECT @tanggalMin as tanggalMin, @tanggalMax as tanggalMax
            ;
            DROP TEMPORARY TABLE tb_list_yearperiod;
        ELSEIF (@tipe = '100') THEN
            SELECT * FROM tb_list_yearperiod
            ;
        ELSE
            SELECT *, periode as nama FROM tb_list_yearperiod
            ;
            DROP TEMPORARY TABLE tb_list_yearperiod;
        END IF;

        

    END$$
DELIMITER ;
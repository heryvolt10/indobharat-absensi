BEGIN
    DECLARE iYear varchar(4)  DEFAULT 0;
    DECLARE iPeriod varchar(2)  DEFAULT 0;
    DECLARE id int DEFAULT 0;
    DECLARE l_count1 int DEFAULT 1;
    DECLARE l_count2 int DEFAULT 1;
    DECLARE l_count3 int DEFAULT 1;
    SET @iYear = in_iYear;
    SET @iPeriod = in_iPeriod;
    SET @id = in_id;
/* TOTAL HOUR DAN INDEX PER DIVISI */
CREATE TEMPORARY TABLE IF NOT EXISTS tp_totalhour_divisi (
	fDivision int,
	dTotalHourDivision decimal(18,2),
    dTotalHourDivisionHL decimal(18,2),
    iTotalIndexPerDivision int,
    iManPower int,
    iTotalNoMasukPerDivision int
); 
INSERT INTO tp_totalhour_divisi
SELECT B.fDivision, SUM(A.dTotalHour) as dTotalHourDivision, SUM(A.dTotalHourHL) as dTotalHourDivisionHL, SUM(A.iIndex) as iTotalIndexPerDivision, COUNT(A.fEmployee) as iManPower, 
SUM(A.iTotalNoMasuk) as iTotalNoMasukPerDivision
FROM data_payroll_detail A
INNER JOIN data_payroll_division B ON B.fDivision = A.fDivision AND B.fid = A.fid
WHERE A.fid = @id 
GROUP BY A.fDivision
;
/*SELECT * FROM tp_totalhour_divisi;*/
/*UPDATE KE TABLE PAYROLL DETAIL*/
UPDATE data_payroll_detail A
INNER JOIN tp_totalhour_divisi B ON B.fDivision = A.fDivision 
SET A.dTotalHourDivision = B.dTotalHourDivision,
A.dTotalHourDivisionHL = B.dTotalHourDivisionHL,
A.iTotalIndexPerDivision = B.iTotalIndexPerDivision,
A.iManPower = B.iManPower
WHERE A.fid = @id AND A.fDivision = B.fDIvision
;
/* TOTAL RATE * JAM KERJA */
CREATE TEMPORARY TABLE IF NOT EXISTS tp_nilairatehour (
    fEmployee int,
	cTotNilai decimal(18,2),
    cTotNilaiHL decimal(18,2),
    dJamLembur decimal(18,2),
    cTotNilaiLembur decimal(18,2),
    cTotNilaiLemburHariBesar decimal(18,2),
    cJamKerjaKurangDariTotalBulanan decimal(18,2)
); 

INSERT INTO tp_nilairatehour
SELECT A.fEmployee,
CASE WHEN B.iTipeGaji IN (0,5,6,7,8) THEN 
	CASE WHEN B.iTipeGaji IN (0,6,7) THEN 
    (A.dTotalHour) * (A.cSalary/B.iTotalHourWork)
	ELSE (A.dTotalHour * B.cRate)
    END
ELSE 0
END as cTotNilai, 
(A.dTotalHourHL * B.cRateHL) as cTotNilaiHL,
CASE WHEN B.iTipeGaji IN (5,6,7,8,9) THEN 
    CASE WHEN (A.dTotalHour > B.iTotalHourWork) THEN (A.dTotalHour - B.iTotalHourWork)
    ELSE 0
    END  
WHEN B.iTipeGaji IN (0) THEN A.dTotalHourFormLembur
ELSE 0
END as dJamLembur,
CASE WHEN B.iTipeGaji IN (5,6,7,8,9) THEN 
    CASE WHEN (A.dTotalHour > B.iTotalHourWork) THEN
        CASE WHEN B.iTipeGaji IN (6,7) THEN 
            CASE WHEN A.dMaxLembur > 0 THEN
            CASE WHEN ((A.dTotalHour ) - B.iTotalHourWork) > A.dMaxLembur THEN (A.dMaxLembur * (A.cSalary/B.iTotalHourWork))
            ELSE ((A.dTotalHour ) - B.iTotalHourWork) * (A.cSalary/B.iTotalHourWork)
            END
            ELSE 
            ((A.dTotalHour ) - B.iTotalHourWork) * (A.cSalary/B.iTotalHourWork)
            END 
        ELSE 
            CASE WHEN A.dMaxLembur > 0 THEN
                CASE WHEN ((A.dTotalHour ) - B.iTotalHourWork) > A.dMaxLembur THEN (A.dMaxLembur * B.cRate)
                ELSE ((A.dTotalHour ) - B.iTotalHourWork) * B.cRate
                END
            ELSE
            ((A.dTotalHour ) - B.iTotalHourWork) * B.cRate
            END
        END
    ELSE 0
    END
WHEN B.iTipeGaji IN (0) THEN 
    CASE WHEN A.dTotalHourFormLembur > 0 THEN
        CASE WHEN A.dMaxLembur > 0 THEN
            CASE WHEN A.dTotalHourFormLembur > A.dMaxLembur THEN (A.dMaxLembur * (A.cSalary/B.iTotalHourWork))
            ELSE (A.dTotalHourFormLembur * (A.cSalary/B.iTotalHourWork)) 
            END
        ELSE (A.dTotalHourFormLembur * (A.cSalary/B.iTotalHourWork)) 
        END
    ELSE 0
    END
ELSE 0
END as cTotNilaiLembur,
CASE WHEN B.iTipeGaji = 9 THEN 
	    A.dTotalHourHariBesar * B.cLemburHariBesar
ELSE 0
END as cTotNilaiLemburHariBesar,
CASE WHEN B.iTipeGaji IN (5) AND (A.dTotalHour < B.iTotalHourWork) THEN 
	((B.iTotalHourWork - A.dTotalHour) * B.cRate) * -1
ELSE 0
END as cJamKerjaKurangDariTotalBulanan
FROM data_payroll_detail A
INNER JOIN data_payroll_division B ON B.fDivision = A.fDivision AND B.fid = A.fid 
WHERE A.fid = @id
;

/*UPDATE KE TABLE PAYROLL DETAIL*/
UPDATE data_payroll_detail A
INNER JOIN tp_nilairatehour B ON B.fEmployee = A.fEmployee
SET A.cNilaiNoHL = B.cTotNilai,
A.cNilaiHL = B.cTotNilaiHL,
A.dJamLembur = B.dJamLembur,
A.cTotNilaiLembur = B.cTotNilaiLembur,
A.cTotNilaiLemburHariBesar = B.cTotNilaiLemburHariBesar
WHERE A.fid = @id AND A.fEmployee = B.fEmployee
;
/* CARI TOTAL JAM KERJA DAN RATE DIVISI YANG ADA INCLUDE KE DIVISI LAIN */
CREATE TEMPORARY TABLE IF NOT EXISTS tp_hlinclude (
	fDivision int,
    fDivisionInclude int,
	cNilaiDivInclude decimal(18,2)
);
INSERT INTO tp_hlinclude
SELECT A.fDivision, A.fDivisionInclude, SUM(B.dTotalHour*C.cRateHL) as cNilai 
FROM data_payroll_division A
INNER JOIN data_payroll_detail B ON B.fDivision = A.fDivisionInclude AND B.fid = A.fid     
INNER JOIN data_payroll_division C ON C.fDivision = A.fDivisionInclude AND C.fid = A.fid   
WHERE A.fid = @id AND A.fDivisionInclude <> 0  
GROUP BY A.fDivision, A.fDivisionInclude
;
/*Update Total cDivInclude*/
UPDATE data_payroll_detail A
JOIN tp_hlinclude B ON B.fDivision = A.fDivision
SET A.cDivInclude = B.cNilaiDivInclude
WHERE A.fid = @id AND A.fDivision = B.fDivision
;
/* HITUNG POT IJIN, INTENSIF KEHADIRAN 
sakit dengan keterangan 25
sakit kalau tanpa keterangan 2x ctsakit
*/
CREATE TEMPORARY TABLE IF NOT EXISTS tp_absen_kehadiran (
	fEmployee int,
    fDivision int,
    iTotalNoMasuk int,
	cNilaiInfKehadiran decimal(18,2),
    cPotIjin decimal(18,2),
    cTotalInfKehadiran decimal(18,2),
    cNilaiInfKecKerja decimal(18,2),
    cNilaiUangMakan decimal(18,2),
    cPotIjinByUMR decimal(18,2),
    cTotalUangPanasJaminan decimal(18,2)
);
INSERT INTO tp_absen_kehadiran
SELECT X.fEmployee, X.fDivision, X.iTotalNoMasuk, X.cNilaiInfKehadiran, 
X.cPotIjin,
CASE WHEN X.fStatusKerja = 1 THEN 
	CASE WHEN X.iTotalNoMasuk > 1 THEN
	((X.cUpahKehadiran_dasar * -1) * (X.iTotalNoMasuk - 1))
    ELSE 
    X.cNilaiInfKehadiran
    END
ELSE 
    X.cNilaiInfKehadiran + (X.cPotIjin)
END as cTotalInfKehadiran, 
X.cNilaiKecKerja, X.cNilaiUangMakan, X.cPotIjinByUMR, X.cTotalUangPanasJaminan
FROM (
    SELECT A.fEmployee, A.fDivision, A.iTotalNoMasuk,B.fStatusKerja,
    CASE WHEN A.iTipeGaji IN (1,2) THEN
        CASE WHEN A.iTotalNoMasuk > 0 OR A.iTotalTelat > 1 THEN 0 
            ELSE B.cInfKehadiran
        END 
    ELSE 
        CASE WHEN A.iTotalNoMasuk > 0 THEN 0 
            ELSE B.cInfKehadiran
        END 
    END as cNilaiInfKehadiran,
    CASE WHEN B.fStatusKerja = 1 THEN 
        CASE WHEN A.iTipeGaji = 9 THEN 
            CASE WHEN (A.ctIzin + A.ctAlpa) > 1 THEN  
                ((B.cUpahKehadiran / C.iDayPeriod) * -1) * (A.iTotalNoMasuk)
            ELSE 0
            END
        ELSE 
            CASE WHEN A.iTotalNoMasuk > 0 THEN
                ((B.cUpahKehadiran / C.iDayPeriod) * -1) * (A.iTotalNoMasuk)
            ELSE 0
            END
        END
    ELSE 
        CASE WHEN A.iTotalNoMasuk > 1 THEN
         ((IF( (A.ctIzin + A.ctAlpa + A.ctSakit) > 0, (A.ctIzin + A.ctAlpa + A.ctSakit - (IF(A.iTypeTopKehadiran = 1,1,0)) ) * 4,0) + (IF(A.ctSakitKet > 0, A.ctSakitKet - (IF(A.iTypeTopKehadiran = 2,1,0)),0))   )) * (CAST(((A.cSalary * 0.25)/C.iDayPeriod) as decimal(18,2))) * -1
    ELSE 0
        END
    END as cPotIjin,
    CASE WHEN B.fStatusKerja = 1 THEN 
        CASE WHEN A.iTipeGaji = 9 THEN 
            CASE WHEN (A.ctIzin + A.ctAlpa) > 1 THEN  
                ((B.cUpahKehadiran / C.iDayPeriod) * -1) * (A.iTotalNoMasuk -1)
            ELSE '0'
            END
        ELSE
            CASE WHEN A.iTotalNoMasuk > 1 THEN
                ((B.cUpahKehadiran / C.iDayPeriod) * -1) * (A.iTotalNoMasuk -1)
            ELSE '0'
            END
        END
    ELSE 
        CASE WHEN A.iTotalNoMasuk > 1 THEN
             ((((A.ctIzin + A.ctAlpa + A.ctSakit) * 4) + A.ctSakitKet)) * (CAST(((A.cSalary * 0.25)/C.iDayPeriod) as decimal(18,2))) * -1
        ELSE '0'
        END
    END as cPotIjinTemp,    
    (B.cUpahKehadiran/C.iDayPeriod) as cUpahKehadiran_dasar, 
        (((B.cRate * B.iTotalHourWork)/C.iDayPeriod) * A.ctKecKerja) as cNilaiKecKerja,
    CASE WHEN A.iTotalNoMasuk > 1 THEN
        B.cUangMakan - (CAST((B.cUangMakan/C.iDayPeriod) as decimal(18,2)) * A.iTotalNoMasuk)
    ELSE B.cUangMakan
    END as cNilaiUangMakan,
    CASE WHEN A.iTotalNoMasuk > 1 THEN
        (CAST((B.cUMR/C.iDayPeriod) as decimal(18,2)) * (A.iTotalNoMasuk - 1))
    ELSE 0
    END as cPotIjinByUMR,
    CASE WHEN B.iTipeGaji in (1) THEN 
        CASE WHEN A.iTotalNoMasuk <= 1 THEN B.cUangPanasJaminan
            ELSE 0
        END
    ELSE 0
    END as cTotalUangPanasJaminan
    FROM data_payroll_detail A 
    INNER JOIN data_payroll_division B ON B.fDivision = A.fDivision AND B.fid = A.fid
    INNER JOIN data_payroll_setting C ON C.fid = A.fid
    WHERE A.fid = @id
) X     
;
/*UPDATE KE TABLE PAYROLL DETAIL*/
UPDATE data_payroll_detail A
INNER JOIN tp_absen_kehadiran B ON B.fEmployee = A.fEmployee 
SET A.cInfKehadiran = B.cNilaiInfKehadiran,
A.cNilaiInfKehadiran = B.cTotalInfKehadiran,
A.cInfKecKerja = B.cNilaiInfKecKerja,
A.cPotIjin = B.cPotIjin,
A.cNilaiUangMakan = B.cNilaiUangMakan
WHERE A.fid = @id AND A.fEmployee = B.fEmployee
;

/* CARI TOTAL SISA DIBAGI */
CREATE TEMPORARY TABLE IF NOT EXISTS tp_sisadibagi (
	fDivision int,
	iType int,
	cTotalSisaDibagi decimal(18,2)
);
INSERT INTO tp_sisadibagi
SELECT B.fDivision, A.iType,
CAST(SUM(A.cNilai * A.cRate) as decimal(18,2)) as cTotalSisaDibagi
FROM data_payroll_divisiondet A
INNER JOIN data_payroll_division B ON B.id = A.fid 
WHERE B.fid = @id
GROUP BY B.fDivision, A.iType
;

/*Update Total Peleburan atau uang panas tipe 1*/
UPDATE data_payroll_detail A
INNER JOIN tp_sisadibagi B ON B.fDivision = A.fDivision AND B.iType = 1
SET A.cTotInfPeleburan = B.cTotalSisaDibagi
WHERE A.fid = @id AND A.fDivision = B.fDivision
;
/*Update Total sisa dibagi tipe 2*/
UPDATE data_payroll_detail A
INNER JOIN tp_sisadibagi B ON B.fDivision = A.fDivision AND B.iType = 2
SET A.cTotInfSisaDibagi = B.cTotalSisaDibagi
WHERE A.fid = @id AND A.fDivision = B.fDivision
;

/* CARI TOTAL additional selain minimal borongan dan rate intensif produksi */
CREATE TEMPORARY TABLE IF NOT EXISTS tp_intensif_additional (
	fDivision int,
	cTotalAdditional decimal(18,2)
);
INSERT INTO tp_intensif_additional
SELECT B.fDivision, CAST(SUM(A.cNilai * A.cRate) as decimal(18,2)) as cTotalAdditional
FROM data_payroll_divisiondet A
INNER JOIN data_payroll_division B ON B.id = A.fid 
WHERE B.fid = @id AND A.iType = 3 AND A.fPayroll_fg NOT IN (48,49)
GROUP BY B.fDivision
;


/*HITUNG GAJI BORONGAN MITRA  */
CREATE TEMPORARY TABLE IF NOT EXISTS tp_gajiborongan (
	fEmployee int,
    sDivision varchar(100),
    cUpahKehadiran decimal(18,2),
	cNilaiHL decimal(18,2),
    cTotalSisaDibagi decimal(18,2),
    cNilaiDivInclude  decimal(18,2),
    dTotalHourDivision decimal(18,2),
    cKomisiBoronganPerJam decimal(18,2),
	cGajiBorongan decimal(18,2),
	cTotalGajiBorongan decimal(18,2)
);
INSERT INTO tp_gajiborongan
SELECT X.*, (X.cGajiBorongan + X.cNilaiHL + X.cUpahKehadiran) cTotalGajiBorongan  
FROM (
	SELECT A.fEmployee, A.sDivision, B.cUpahKehadiran, (CAST((A.dTotalHourHL * B.cRateHL)as decimal(18,2))) as cNilaiHL, IFNULL(D.cTotalSisaDibagi,0), IFNULL(E.cNilaiDivInclude,0), C.dTotalHourDivision,
    CASE WHEN B.iTipeGaji IN (1,2,4) THEN CAST((((((IFNULL(D.cTotalSisaDibagi,0) - (IFNULL(G.cNilai,0) * IFNULL(G.cRate,0))) * (IFNULL(F.cNilai,0) * IFNULL(F.cRate,0))) + (IFNULL(H.cTotalAdditional,0)) + ((A.iManPower * B.cUMR) - IFNULL(I.cPotIjinByUMRPerDivision,0) )) / C.dTotalHourDivision)) as decimal(18,2))
    ELSE 
        '0'
    END as cKomisiBoronganPerJam,
    CASE WHEN B.iTipeGaji IN (1,2,4) THEN CAST((((((IFNULL(D.cTotalSisaDibagi,0) - (IFNULL(G.cNilai,0) * IFNULL(G.cRate,0))) * (IFNULL(F.cNilai,0) * IFNULL(F.cRate,0))) + (IFNULL(H.cTotalAdditional,0)) + ((A.iManPower * B.cUMR) - IFNULL(I.cPotIjinByUMRPerDivision,0) )) / C.dTotalHourDivision) * A.dTotalHour) as decimal(18,2))
    WHEN B.iTipeGaji = 3 THEN CAST((((IFNULL(D.cTotalSisaDibagi,0) ) / C.dTotalHourDivision) * A.dTotalHour) as decimal(18,2))
    ELSE 
        '0'
    END as cGajiBorongan
    FROM data_payroll_detail A
    INNER JOIN data_payroll_division B ON B.fDivision = A.fDivision AND B.fid = A.fid
    INNER JOIN tp_totalhour_divisi C ON C.fDivision = A.fDivision
    LEFT JOIN tp_sisadibagi D ON D.fDivision = A.fDivision AND D.iType = 2 
    LEFT JOIN tp_hlinclude E ON E.fDivision = A.fDivision  
    LEFT JOIN data_payroll_divisiondet F ON F.fid = B.id AND F.iType = 3 AND F.fPayroll_fg = 48
    LEFT JOIN data_payroll_divisiondet G ON G.fid = B.id AND G.iType = 3 AND G.fPayroll_fg = 49
    LEFT JOIN tp_intensif_additional H ON H.fDivision = B.fDivision
    LEFT JOIN (SELECT fDivision, SUM(cPotIjinByUMR) as cPotIjinByUMRPerDivision FROM tp_absen_kehadiran GROUP BY fDivision) I ON I.fDivision = A.fDivision
    WHERE A.fid = @id 
    AND B.iTipeGaji IN (1,2,3,4)
    AND B.fStatusKerja = 1
) X
;


/* WHEN B.iTipeGaji = 3 THEN CAST((((IFNULL(D.cTotalSisaDibagi,0) - (C.dTotalHourDivisionHL*B.cRateHL)) / C.dTotalHourDivision) * A.dTotalHour) as decimal(18,2))*/
   


UPDATE data_payroll_detail
SET cNilaiBorongan = 0,
cKomisiBoronganPerJam = 0,
cTotalNilaiBorongan = 0,
cNilaiUangPanas = 0
WHERE fid = @id ;


/*
SELECT * FROM tp_gajiborongan
WHERE sDivision = 'BR1'
;*/
/*UPDATE KE TABLE PAYROLL DETAIL*/
UPDATE data_payroll_detail A
JOIN tp_gajiborongan B ON B.fEmployee = A.fEmployee
SET A.cNilaiBorongan = IFNULL(B.cGajiBorongan,0),
A.cKomisiBoronganPerJam = IFNULL(B.cKomisiBoronganPerJam,0),
A.cTotalNilaiBorongan = IFNULL(B.cTotalGajiBorongan,0)
WHERE A.fid = @id AND A.fEmployee = B.fEmployee
;
 /*HITUNG UANG PANAS MITRA  */
CREATE TEMPORARY TABLE IF NOT EXISTS tp_uangpanas (
	fEmployee int,
	cUangPanas decimal(18,2)
);
INSERT INTO tp_uangpanas
SELECT A.fEmployee, 
CAST(((IFNULL(D.cTotalSisaDibagi, 0) / C.iTotalIndexPerDivision) * A.iIndex) as decimal(18,2))
as cUangPanas 
FROM data_payroll_detail A
INNER JOIN data_payroll_division B ON B.fDivision = A.fDivision AND B.fid = A.fid
INNER JOIN tp_totalhour_divisi C ON C.fDivision = B.fDivision
LEFT JOIN tp_sisadibagi D ON D.fDivision = B.fDivision AND D.iType = 1 
WHERE A.fid = @id AND B.iTipeGaji IN (1,2,3,4)
;
/*
SELECT * FROM tp_uangpanas;*/
/*UPDATE KE TABLE PAYROLL DETAIL*/
UPDATE data_payroll_detail A
INNER JOIN tp_uangpanas B ON B.fEmployee = A.fEmployee
SET A.cNilaiUangPanas = IFNULL(B.cUangPanas,0)
WHERE A.fid = @id AND A.fEmployee = B.fEmployee
;

/*KABAG dan SPV tipe gaji 8*/
CREATE TEMPORARY TABLE IF NOT EXISTS tp_kabagspv (
	fEmployee int,
	cTotalSisaDibagiKabag decimal(18,2)
);
INSERT INTO tp_kabagspv
SELECT A.fEmployee, C.cTotalSisaDibagi 
FROM data_payroll_detail A
INNER JOIN data_payroll_division B ON B.fDivision = A.fDivision AND B.fid = A.fid
INNER JOIN tp_sisadibagi C ON C.fDivision = A.fDivision AND C.iType = 2
WHERE A.fid = @id AND B.iTipeGaji = 7
;
UPDATE data_payroll_detail A
INNER JOIN tp_kabagspv B ON B.fEmployee = A.fEmployee
SET A.cNilaiBorongan = B.cTotalSisaDibagiKabag
WHERE A.fid = @id AND A.fEmployee = B.fEmployee
;
/*Kumpulkan seua data payroll additional*/
    CREATE TEMPORARY TABLE IF NOT EXISTS tp_pay_additional (
        fEmployee int,
        iType int,
        cTotalAdd decimal(18,2)
    );
    INSERT INTO tp_pay_additional
    SELECT A.fEmployee, B.iType, 
    CASE WHEN B.iType = 1 THEN SUM(A.cNilai)
    WHEN B.iType = 2 THEN (SUM(A.cNilai) * -1)
    ELSE 0
    END as cTotalAdd
    FROM data_payroll_additional A    
    INNER JOIN master_payroll_additional B ON B.id = A.fAdditional
        WHERE A.iStatus = 2 AND A.iYear = @iYear AND A.iPeriod = @iPeriod
        GROUP BY A.fEmployee, B.iType
        ;
UPDATE data_payroll_detail A
LEFT JOIN tp_pay_additional B ON B.fEmployee = A.fEmployee AND B.iType = 1
SET A.cTambahAdd = IFNULL(B.cTotalAdd,0)
WHERE A.fid = @id 
;
UPDATE data_payroll_detail A
LEFT JOIN tp_pay_additional B ON B.fEmployee = A.fEmployee AND B.iType = 2
SET A.cPotAdd = IFNULL(B.cTotalAdd,0)
WHERE A.fid = @id 
;
/*
UPDATE data_payroll_detail
SET cTambahAdd = 0,
cPotAdd = 0
WHERE fid = @id AND fEmployee NOT IN (SELECT fEmployee FROM tp_pay_additional GROUP BY fEmployee)
;
 */  
/*Kumpulkan seua data payroll hl sortir untuk kerja luar*/
CREATE TEMPORARY TABLE IF NOT EXISTS tp_kerjaluar (
	fEmployee int,
	ictHL int,
    cNilaiKerjaLuar decimal(18,2)
);
INSERT INTO tp_kerjaluar 
SELECT X.fEmployee, IFNULL(X.ctHL,0), 
CASE WHEN Y.iTipeGaji = 8 THEN ((Y.cUpahKehadiran / Z.iDayPeriod) * IFNULL(X.ctHL,0)) 
    WHEN Y.iTipeGaji = 9 THEN IFNULL(X.ctHL,0) * Y.cLemburLuarKota 
ELSE 0
END as cNilaiKerjaLuar
FROM (
    SELECT A.fEmployee, A.fid, A.fDivision, SUM(B.iHL) as ctHL 
    FROM data_payroll_detail A
    INNER JOIN data_absen B ON B.fEmployee = A.fEmployee
    WHERE B.iYear = @iYear AND B.iPeriod = @iPeriod
    AND A.fid = @id
    AND B.iStatus = 4
    GROUP BY A.fEmployee
) X
INNER JOIN data_payroll_division Y ON Y.fDivision = X.fDivision AND Y.fid = X.fid
INNER JOIN data_payroll_setting Z ON Z.fid = X.fid
;
UPDATE data_payroll_detail A
LEFT JOIN tp_kerjaluar B ON B.fEmployee = A.fEmployee
SET A.ictHL = IFNULL(B.ictHL,0),
A.cNilaiKerjaLuar = IFNULL( B.cNilaiKerjaLuar,0)
WHERE A.fid = @id AND A.fEmployee = B.fEmployee
;
/*Kumpulkan seua data payroll additional*/
CREATE TEMPORARY TABLE IF NOT EXISTS tp_grandtotal (
	fEmployee int,
	cGrandTotal decimal(18,2)
);
INSERT INTO tp_grandtotal
SELECT A.fEmployee,
CASE WHEN B.iTipeGaji IN (1,2,3,4) THEN
(A.cTotalNilaiBorongan + A.cNilaiInfKehadiran +  A.cNilaiUangPanas + A.cTunjangan + A.cInfKecKerja + H.cTotalUangPanasJaminan ) 
WHEN B.iTipeGaji = 5 THEN
(A.cNilaiInfKehadiran + A.cTunjangan + A.cIntensifAhli + B.cUpahKehadiran + B.cInfTarget + B.cInfSafety + B.cInfDisiplin + A.cTotNilaiLembur + A.cNilaiHL + IFNULL(G.cJamKerjaKurangDariTotalBulanan,0) ) 
WHEN B.iTipeGaji = 8 THEN
(A.cNilaiInfKehadiran + A.cTunjangan + A.cIntensifAhli + B.cUpahKehadiran + B.cInfTarget + B.cInfSafety + B.cInfDisiplin + A.cNilaiNoHL + A.cNilaiHL - IFNULL(F.cNilaiKerjaLuar,0) ) 
WHEN B.iTipeGaji = 9 THEN
(A.cNilaiInfKehadiran + A.cTunjangan + A.cIntensifAhli + B.cUpahKehadiran + B.cInfTarget + B.cInfSafety + B.cInfDisiplin + A.cNilaiUangMakan + A.cTotNilaiLembur + A.cTotNilaiLemburHariBesar +  IFNULL(F.cNilaiKerjaLuar,0) ) 
WHEN B.iTipeGaji = 0 THEN 
(A.cNilaiNoHL + A.cNilaiInfKehadiran + A.cTunjangan + A.cTotNilaiLembur) 
ELSE 
(A.cNilaiNoHL + A.cNilaiHL + A.cNilaiBorongan + A.cTunjangan + A.cIntensifAhli + B.cUpahKehadiran + B.cInfTarget + B.cInfSafety + B.cInfDisiplin + A.cNilaiInfKehadiran ) 
END as cGrandTotal
FROM data_payroll_detail A
INNER JOIN data_payroll_division B ON B.fDivision = A.fDivision AND B.fid = A.fid
LEFT JOIN tp_pay_additional C ON C.fEmployee = A.fEmployee AND C.iType = 1
LEFT JOIN tp_pay_additional D ON D.fEmployee = A.fEmployee AND D.iType = 2
INNER JOIN data_payroll_setting E ON E.fid = A.fid
LEFT JOIN tp_kerjaluar F ON F.fEmployee = A.fEmployee
LEFT JOIN tp_nilairatehour G ON G.fEmployee = A.fEmployee
LEFT JOIN tp_absen_kehadiran H ON H.fEmployee = A.fEmployee
   

WHERE A.fid = @id    
;
/*
(
    SELECT A.fEmployee, SUM(B.iHL) as ctHL FROM data_payroll_detail A
    INNER JOIN data_absen B ON B.fEmployee = A.fEmployee
    WHERE A.iTipeGaji = 8
    AND B.iYear = @iYear AND B.iPeriod = @iPeriod
    AND B.iHL = 1
    AND A.fid = @id
    AND B.iStatus = 4
    GROUP BY A.fEmployee
) F ON F.fEmployee = A.fEmployee
*/
UPDATE data_payroll_detail A
INNER JOIN tp_grandtotal B ON B.fEmployee = A.fEmployee
SET A.cGrandTotal = B.cGrandTotal,
A.cGrandTotalTemp = B.cGrandTotal
WHERE A.fid = @id AND A.fEmployee = B.fEmployee
;
/*Hitung Gaji Jaminan Mitra*/
CREATE TEMPORARY TABLE IF NOT EXISTS tp_gajijaminan (
	fEmployee int,
	cGajiJaminan decimal(18,2)
);
INSERT INTO tp_gajijaminan
SELECT A.fEmployee,
    CASE WHEN B.iTipeGaji in (1,2,3,4) THEN 
        CASE WHEN B.iTipeGaji in (1) THEN 
            CASE WHEN A.iTotalNoMasuk <= 1 THEN
                ((((B.cRate * B.iTotalHourWork) * A.iManPower) / (A.dTotalHourDivision + A.dTotalHourDivisionHL)) * A.dTotalHour) + B.cUangPanasJaminan + A.cTunjangan + A.cNilaiInfKehadiran + A.cInfKecKerja
             ELSE 
                ((((B.cRate * B.iTotalHourWork) * A.iManPower) / (A.dTotalHourDivision + A.dTotalHourDivisionHL)) * A.dTotalHour) + B.cUangPanasJaminan + A.cTunjangan + (((B.cRate * B.iTotalHourWork/C.iDayPeriod)*(A.iTotalNoMasuk-1))*-1) 
           END
        WHEN B.iTipeGaji in (2) THEN 
            CASE WHEN A.iTotalNoMasuk <= 1 THEN
                ((((B.cRate * B.iTotalHourWork) * A.iManPower) / A.dTotalHourDivision) * A.dTotalHour) + B.cUangPanasJaminan + A.cTunjangan + A.cNilaiInfKehadiran + A.cInfKecKerja
            ELSE 
                ((((B.cRate * B.iTotalHourWork) * A.iManPower) / A.dTotalHourDivision) * A.dTotalHour) + B.cUangPanasJaminan + A.cTunjangan + (((B.cRate * B.iTotalHourWork/C.iDayPeriod)*(A.iTotalNoMasuk-1))*-1)  + A.cInfKecKerja
            END
        WHEN B.iTipeGaji in (3) THEN 
            CASE WHEN A.iTotalNoMasuk <= 1 THEN
                ((((B.cRate * B.iTotalHourWork) * A.iManPower) / (A.dTotalHourDivision + A.dTotalHourDivisionHL)) * (A.dTotalHour + A.dTotalHourHL)) + B.cUangPanasJaminan + A.cTunjangan + A.cInfKehadiran + A.cInfKecKerja
            ELSE 
                ((((B.cRate * B.iTotalHourWork) * A.iManPower) / (A.dTotalHourDivision + A.dTotalHourDivisionHL)) * (A.dTotalHour + A.dTotalHourHL)) + A.cTunjangan + A.cInfKehadiran + A.cInfKecKerja
            END
        ELSE 
            ((((B.cRate * B.iTotalHourWork) * A.iManPower) / A.dTotalHourDivision) * A.dTotalHour) + B.cUangPanasJaminan + A.cTunjangan + A.cInfKehadiran + A.cInfKecKerja
        END
    ELSE 0
    END as cGajiJaminan
FROM data_payroll_detail A
INNER JOIN data_payroll_division B ON B.fDivision = A.fDivision AND B.fid = A.fid
INNER JOIN data_payroll_setting C ON C.fid = A.fid
WHERE A.fid = @id    
;
UPDATE data_payroll_detail A
INNER JOIN tp_gajijaminan B ON B.fEmployee = A.fEmployee
SET A.cGajiJaminan = B.cGajiJaminan
WHERE A.fid = @id AND A.fEmployee = B.fEmployee
;
/*Bandingkan Gaji Jainan dan GrandTotal untuk Mitra TipeGaji 1,2 3,4*/
CREATE TEMPORARY TABLE IF NOT EXISTS tp_grandtotal_replace (
	fDivision int,
	iReplaceGrandTotal int
);
INSERT INTO tp_grandtotal_replace
SELECT X.fDivision,
CASE WHEN X.sumGrandTotalTemp < X.sumcGajiJaminan THEN 1 
ELSE 0
END as iReplaceGrandTotal
 FROM (
    SELECT A.fDivision, SUM(A.cGrandTotalTemp) as sumGrandTotalTemp, SUM(A.cGajiJaminan) as sumcGajiJaminan
    FROM data_payroll_detail A
    INNER JOIN data_payroll_division B ON B.fDivision = A.fDivision AND B.fid = A.fid
    WHERE A.fid = @id AND B.iTipeGaji in (1,2,3,4)
    GROUP BY A.fDivision  
) X
;
UPDATE data_payroll_detail A
INNER JOIN data_payroll_division B ON B.fDivision = A.fDivision AND B.fid = A.fid
INNER JOIN tp_grandtotal_replace C ON C.fDivision = A.fDivision AND C.iReplaceGrandTotal = 1
SET A.cGrandTotal = A.cGajiJaminan
WHERE A.fid = @id AND A.fDivision = A.fDivision AND B.iTipeGaji in (1,2,3,4)
;

CREATE TEMPORARY TABLE IF NOT EXISTS tp_pot_bpjs (
        fEmployee int,
     	fStatusKerja int,
        cPot_iPK_BPJS_TK decimal(18,2),
        cPot_iPK_BPJS_JHT decimal(18,2),
        cPot_iPK_BPJS_Kes decimal(18,2),
        cPot_iBP_BPJS_TK decimal(18,2),
        cPot_iBP_BPJS_JHT decimal(18,2),
        cPot_iBP_BPJS_Kes decimal(18,2),
        bruto_ip_JKM decimal(18,2),
        bruto_ip_Kes decimal(18,2)
    );
    INSERT INTO tp_pot_bpjs
    SELECT A.fEmployee, A.fStatusKerja,
    CASE WHEN A.fStatusKerja = 1 THEN 0
    ELSE 
    	CASE WHEN A.iKelasBPJS_KTN = 0 THEN 0
        ELSE C.cUMR * B.iPK_BPJS_TK / 100
        END
    END as cPot_iPK_BPJS_TK,
    CASE WHEN A.fStatusKerja = 1 THEN 0
    ELSE 
    	CASE WHEN A.iKelasBPJS_KTN = 0 THEN 0
        ELSE C.cUMR * B.iPK_BPJS_Pensiun / 100
        END
    END as cPot_iPK_BPJS_JHT,
   CASE WHEN A.fStatusKerja = 1 THEN 0
    ELSE
    	CASE WHEN A.iKelasBPJS_KES = 0 THEN 0
        ELSE C.cUMR * B.iPK_BPJS_Kes / 100
        END
    END as cPot_iPK_BPJS_Kes,
   CASE WHEN A.fStatusKerja = 1 THEN 0
    ELSE 
    	CASE WHEN A.iKelasBPJS_KTN = 0 THEN 0
        ELSE C.cUMR * B.iBP_BPJS_TK / 100
        END
    END as cPot_iBP_BPJS_TK,
    CASE WHEN A.fStatusKerja = 1 THEN 0
    ELSE 
    	CASE WHEN A.iKelasBPJS_KTN = 0 THEN 0
        ELSE C.cUMR * B.iBP_BPJS_Pensiun / 100
        END
    END as cPot_iBP_BPJS_JHT,
    CASE WHEN A.fStatusKerja = 1 THEN 0
    ELSE 
    	CASE WHEN A.iKelasBPJS_KES = 0 THEN 0
        ELSE C.cUMR * B.iBP_BPJS_Kes / 100
        END
    END as iBP_BPJS_Kes,
    CASE WHEN A.fStatusKerja = 1 THEN 0
    ELSE 
    	CASE WHEN A.iKelasBPJS_KTN = 0 THEN 0
        ELSE C.cUMR * B.ip_JKM / 100
        END
    END as ip_JKM,
    CASE WHEN A.fStatusKerja = 1 THEN 0
    ELSE 
    	CASE WHEN A.iKelasBPJS_KES = 0 THEN 0
        ELSE C.cUMR * B.ip_Kes / 100
        END
    END as ip_Kes
    FROM data_payroll_detail A
    INNER JOIN data_payroll_setting B ON B.fid = A.fid
	INNER JOIN data_payroll_division C ON C.fDivision = A.fDivision AND C.fid = A.fid
    WHERE A.fid = @id
        ;
UPDATE data_payroll_detail A
INNER JOIN tp_pot_bpjs B ON B.fEmployee = A.fEmployee
SET A.cPot_BPJS_TK = B.cPot_iPK_BPJS_TK,
	A.cPot_BPJS_JHT = B.cPot_iPK_BPJS_JHT,
	A.cPot_BPJS_Kes = B.cPot_iPK_BPJS_Kes,
    A.cBruto_ip_JKM = B.bruto_ip_JKM,
    A.cBruto_ip_Kes = B.bruto_ip_Kes
WHERE A.fid = @id AND A.fEmployee = B.fEmployee
;
/* PH Bruto - Additional */
CREATE TEMPORARY TABLE IF NOT EXISTS tp_phbruto (
        rowNum int AUTO_INCREMENT PRIMARY KEY,
        fEmployee int,
        cPHBruto decimal(18,2)
    );
    INSERT INTO tp_phbruto
    SELECT '' as rowNum, A.fEmployee,
    CASE WHEN A.fStatusKerja = 1 THEN 0
    ELSE A.cGrandTotal + B.bruto_ip_JKM + B.bruto_ip_Kes
    END as cPHBruto
    FROM data_payroll_detail A
    INNER JOIN tp_pot_bpjs B ON B.fEmployee = A.fEmployee
    WHERE A.fid = @id AND A.fStatusKerja <> 1
    ;
UPDATE data_payroll_detail A
INNER JOIN tp_phbruto B ON B.fEmployee = A.fEmployee
SET A.cPHBruto = B.cPHBruto
WHERE A.fid = @id AND A.fEmployee = B.fEmployee
;
SET @ctData = (SELECT COUNT(rowNum) FROM tp_phbruto);
loopTR1: LOOP
IF  l_count1 < (@ctData + 1) THEN 
        SET @cPHBrutoTR1 = (SELECT cPHBruto FROM tp_phbruto WHERE rowNum = l_count1);
        SET @fEmployeeTR1 = (SELECT fEmployee FROM tp_phbruto WHERE rowNum = l_count1);
		UPDATE data_payroll_detail
        SET ter1 = (
            SELECT Persen
            FROM master_terptkp
            WHERE cNilai >= @cPHBrutoTR1
            AND iType = 1
            ORDER BY cNilai ASC
            LIMIT 1 
        )
        WHERE fid = @id AND fEmployee = @fEmployeeTR1;
        UPDATE data_payroll_detail
        SET ter2 = (
            SELECT Persen
            FROM master_terptkp
            WHERE cNilai >= @cPHBrutoTR1
            AND iType = 2
            ORDER BY cNilai ASC
            LIMIT 1 
        )
        WHERE fid = @id AND fEmployee = @fEmployeeTR1;
        UPDATE data_payroll_detail
        SET ter3 = (
            SELECT Persen
            FROM master_terptkp
            WHERE cNilai >= @cPHBrutoTR1
            AND iType = 3
            ORDER BY cNilai ASC
            LIMIT 1 
        )
        WHERE fid = @id AND fEmployee = @fEmployeeTR1;
ELSE
	LEAVE  loopTR1;
END  IF;
SET l_count1 = l_count1 + 1;		
END LOOP;
CREATE TEMPORARY TABLE IF NOT EXISTS tp_pph21 (
        fEmployee int,
        cPot_Pph21 decimal(18,2)
    );
INSERT INTO tp_pph21
SELECT A.fEmployee, 
CASE WHEN B.iType = 1 THEN (A.cPHBruto * ter1 / 100)
WHEN  B.iType = 2 THEN (A.cPHBruto * ter2 / 100)
WHEN  B.iType = 3 THEN (A.cPHBruto * ter3 / 100)
ELSE 0 
END as cPot_Pph21
FROM data_payroll_detail A
INNER JOIN master_maritalstatus B ON B.sName = A.sNamePTKP
WHERE A.fid = @id AND A.fStatusKerja <> 1
;
UPDATE data_payroll_detail A
INNER JOIN tp_pph21 B ON B.fEmployee = A.fEmployee
SET A.cPot_Pph21 = B.cPot_Pph21
WHERE A.fid = @id AND A.fEmployee = B.fEmployee AND A.fStatusKerja <> 1
;

CREATE TEMPORARY TABLE IF NOT EXISTS tp_pph21_mitra (
        fEmployee int,
        cPPH21_Mitra decimal(18,2)
    );
    INSERT INTO tp_pph21_mitra
    SELECT A.fEmployee, 
    CASE WHEN A.sNPWP = '' THEN ((A.cGrandTotal + A.cTambahAdd + A.cPotAdd)*50/100) * 6/100
    ELSE ((A.cGrandTotal + A.cTambahAdd + A.cPotAdd) *50/100) * 5/100
    END as cPPH21_Mitra
    FROM data_payroll_detail A
    INNER JOIN data_payroll_division B ON B.fDivision = A.fDivision AND B.fid = A.fid
    WHERE A.fStatusKerja = 1 AND A.fid = @id
    ;
UPDATE data_payroll_detail A
INNER JOIN tp_pph21_mitra B ON B.fEmployee = A.fEmployee
SET A.cPot_Pph21 = B.cPPH21_Mitra
WHERE A.fid = @id AND A.fEmployee = B.fEmployee AND A.fStatusKerja = 1
;
/*update semua cPph21_temp*/
UPDATE data_payroll_detail 
set cPph21_temp = cPot_Pph21
WHERE fid = @id
;
/*Update cPot_Pph21 Final*/
UPDATE data_payroll_detail A 
INNER JOIN data_payroll_division B ON B.fDivision = A.fDivision AND B.fid = @id
SET A.cPot_Pph21 = 0
WHERE A.fid = @id AND B.iNonPph21 = 1
; 
/*TOTAL GAJI FINAL*/
UPDATE data_payroll_detail
SET cTotalGaji = TRUNCATE((cGrandTotal - cPot_BPJS_TK - cPot_BPJS_JHT - cPot_BPJS_kes - cPot_Pph21 + cTambahAdd + cPotAdd),0)
WHERE fid = @id
;



/* DROP TABLE pada procedure ini*/
   DROP TABLE tp_totalhour_divisi;
   DROP TABLE tp_nilairatehour;
   DROP TABLE tp_hlinclude;
   DROP TABLE tp_absen_kehadiran;
   DROP TABLE tp_sisadibagi;
   DROP TABLE tp_intensif_additional;
   DROP TABLE tp_gajiborongan;
   DROP TABLE tp_uangpanas;
   DROP TABLE tp_kabagspv;
   DROP TABLE tp_pay_additional;
   DROP TABLE tp_kerjaluar;
   DROP TABLE tp_grandtotal;
   DROP TABLE tp_gajijaminan;
   DROP TABLE tp_grandtotal_replace;
   DROP TABLE tp_pot_bpjs;
   DROP TABLE tp_phbruto;
 /*  DROP TABLE tp_phnetto;
   DROP TABLE tp_ptkp;
   DROP TABLE tp_pph21_total;*/
   DROP TABLE tp_pph21;  
   DROP TABLE tp_pph21_mitra;
  /* ----DROP TABLE pada procedure ini----*/
END
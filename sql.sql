select * from Sensor_Log where Sensor_ID = 001 ORDER BY Sensor_Timestamp DESC LIMIT 20;
SET SQL_SAFE_UPDATES = 0;
SELECT (MIN(Sensor_Timestamp)) FROM (Sensor_Log)  where Sensor_ID = 001;

DELETE FROM Sensor_Log WHERE Sensor_ID = 002;

SELECT * FROM aqiqinl_MIOT_project.Sensor_Log;
select * from Sensor_Log where Sensor_ID = '001' ORDER BY Sensor_Timestamp;

insert into Sensor_Log (Sensor_ID,Sensor_Timestamp,Last_Sensor_Data) value ('001' ,now(), '50');

select * from Sensor_Log where Sensor_ID = 001 ORDER BY Sensor_Timestamp DESC LIMIT 20;

SELECT @last_id := min(Sensor_Timestamp) FROM Sensor_Log;

SELECT * FROM Sensor_Log 
where Sensor_Timestamp=(select min(Sensor_Timestamp) 
from Sensor_Log where Sensor_ID = '002');

UPDATE Sensor_Log
SET Sensor_ID = '002',Sensor_Timestamp = now(),Last_Sensor_Data = '50'
WHERE Sensor_Timestamp=(select min(Sensor_Timestamp) from (select * from Sensor_Log) temp1 where temp1.Sensor_ID = '002');

UPDATE Device
SET Configuratie_ID = 9
WHERE Device_ID = 'TEST2';

Update Sensor SET Device_Device_ID = 'TEST1' where Sensor_Type = 'Lichtsensor';

SELECT Sensor_Log.Last_Sensor_Data, Sensor_Log.Sensor_ID, Sensor.Sensor_ID, Sensor.Device_Device_ID
from Sensor_Log
Full Join Sensor ON Sensor_Log.Sensor_ID = Sensor.Sensor_ID;


select Last_Sensor_Data, Sensor_Timestamp from Sensor_Log, Sensor where Sensor_Log.Sensor_ID = '002' and Sensor.Sensor_ID = '002' and Device_Device_ID = 'Standby' 
order by Sensor_Timestamp Limit 1;

Select Configuratie_ID from Device where Device_ID = 'Standby'; 

select Last_Sensor_Data,Sensor_Timestamp from Sensor_Log, Sensor where Sensor_Log.Sensor_ID = '002' 
and Sensor.Sensor_ID = '002' and Device_Device_ID = 'Standby' order by Sensor_Timestamp;

UPDATE Sensor_Log,Sensor SET Sensor_Timestamp = now(),Last_Sensor_Data = '200'
WHERE Sensor_Timestamp=(select min(Sensor_Timestamp) from (select * from Sensor_Log) temp1 where temp1.Sensor_ID = '002') and Device_Device_ID = 'Standby'
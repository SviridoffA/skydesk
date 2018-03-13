SELECT 	pswitch , ort , count( * ) 
FROM switchmac1
WHERE date > '2011-05-01'
GROUP BY ipswitch, port ORDER BY ount( * )
<?php
/* ============================================
   AGODA CLONE — _data.php
   Data: Hotels, Flights, Activities
   ============================================ */

$HOTELS = [
  ['id'=>1,'name'=>'The Alana Surabaya','location'=>'Surabaya Pusat','loc_full'=>'Jl. Mayjend Yono Suwoyo, Surabaya Pusat','rating'=>9.4,'reviews'=>1284,'stars'=>5,'base_price'=>650000,'tax_rate'=>0.11,'service_fee'=>25000,'grad'=>'linear-gradient(135deg,#E84393,#FF6B35)','badge'=>'Best Value','amenities'=>['WiFi Gratis','Kolam Renang','Gym','Sarapan','Parkir','AC','TV','Minibar','Spa'],'dist'=>'0.3 km pusat kota','cancel_policy'=>'Gratis batalkan hingga 24 jam sebelum check-in','desc'=>'Hotel bintang 5 di jantung Surabaya dengan fasilitas premium dan pemandangan kota spektakuler.','img_emoji'=>'🏨','category'=>'Hotel'],
  ['id'=>2,'name'=>'Luminor Hotel Surabaya','location'=>'Surabaya Timur','loc_full'=>'Jl. Kepanjen, Surabaya Timur','rating'=>9.0,'reviews'=>876,'stars'=>4,'base_price'=>420000,'tax_rate'=>0.11,'service_fee'=>20000,'grad'=>'linear-gradient(135deg,#FF6B35,#FFA726)','badge'=>'Popular','amenities'=>['WiFi Gratis','Sarapan','Parkir','AC','TV','Kolam Renang'],'dist'=>'1.2 km Pakuwon Mall','cancel_policy'=>'Gratis batalkan hingga 48 jam sebelum check-in','desc'=>'Hotel modern desain kontemporer, pilihan sempurna bisnis maupun liburan di Surabaya.','img_emoji'=>'🏩','category'=>'Hotel'],
  ['id'=>3,'name'=>'Swiss-Belinn Surabaya','location'=>'Surabaya Barat','loc_full'=>'Jl. Indrapura, Surabaya Barat','rating'=>8.6,'reviews'=>532,'stars'=>3,'base_price'=>280000,'tax_rate'=>0.11,'service_fee'=>15000,'grad'=>'linear-gradient(135deg,#FF9800,#FFD54F)','badge'=>'Budget Pick','amenities'=>['WiFi Gratis','AC','Parkir','Minibar'],'dist'=>'0.8 km Bandara Juanda','cancel_policy'=>'Non-refundable — sudah termasuk diskon maksimal','desc'=>'Pilihan cerdas bagi pelancong hemat, lokasi strategis dekat bandara.','img_emoji'=>'🏪','category'=>'Hotel'],
  ['id'=>4,'name'=>'JW Marriott Surabaya','location'=>'Surabaya Pusat','loc_full'=>'Jl. Embong Malang, Surabaya Pusat','rating'=>9.8,'reviews'=>2341,'stars'=>5,'base_price'=>1250000,'tax_rate'=>0.11,'service_fee'=>50000,'grad'=>'linear-gradient(135deg,#E84393,#C62828)','badge'=>'Top Rated','amenities'=>['WiFi Gratis','Kolam Renang','Spa','Gym','Sarapan','Bar','Parkir','AC','TV','Minibar','Concierge'],'dist'=>'0.1 km pusat kota','cancel_policy'=>'Gratis batalkan hingga 72 jam sebelum check-in','desc'=>'Pengalaman menginap tertinggi di Surabaya dengan layanan kelas dunia dan fasilitas mewah.','img_emoji'=>'🏰','category'=>'Hotel'],
  ['id'=>5,'name'=>'POP! Hotel Gubeng','location'=>'Surabaya Tengah','loc_full'=>'Jl. Raya Gubeng, Surabaya','rating'=>8.2,'reviews'=>388,'stars'=>2,'base_price'=>195000,'tax_rate'=>0.11,'service_fee'=>10000,'grad'=>'linear-gradient(135deg,#FF5722,#FF8A65)','badge'=>'Budget Smart','amenities'=>['WiFi Gratis','AC','TV'],'dist'=>'0.2 km Stasiun Gubeng','cancel_policy'=>'Gratis batalkan hingga 24 jam sebelum check-in','desc'=>'Hotel budget modern di lokasi strategis dekat stasiun dan pusat bisnis Surabaya.','img_emoji'=>'🏬','category'=>'Hotel'],
];

$FLIGHTS = [
  ['id'=>101,'airline'=>'Garuda Indonesia','airline_code'=>'GA','from'=>'SUB','from_city'=>'Surabaya','to'=>'CGK','to_city'=>'Jakarta','dep'=>'06:00','arr'=>'07:10','duration'=>'1j 10m','price'=>580000,'class'=>'Ekonomi','seats'=>8,'stops'=>'Langsung','logo'=>'🦅'],
  ['id'=>102,'airline'=>'Lion Air','airline_code'=>'JT','from'=>'SUB','from_city'=>'Surabaya','to'=>'CGK','to_city'=>'Jakarta','dep'=>'08:30','arr'=>'09:50','duration'=>'1j 20m','price'=>299000,'class'=>'Ekonomi','seats'=>23,'stops'=>'Langsung','logo'=>'🦁'],
  ['id'=>103,'airline'=>'Citilink','airline_code'=>'QG','from'=>'SUB','from_city'=>'Surabaya','to'=>'CGK','to_city'=>'Jakarta','dep'=>'11:45','arr'=>'13:10','duration'=>'1j 25m','price'=>345000,'class'=>'Ekonomi','seats'=>15,'stops'=>'Langsung','logo'=>'✈️'],
  ['id'=>104,'airline'=>'Batik Air','airline_code'=>'ID','from'=>'SUB','from_city'=>'Surabaya','to'=>'DPS','to_city'=>'Bali','dep'=>'09:15','arr'=>'10:30','duration'=>'1j 15m','price'=>420000,'class'=>'Ekonomi','seats'=>6,'stops'=>'Langsung','logo'=>'🎭'],
  ['id'=>105,'airline'=>'AirAsia','airline_code'=>'QZ','from'=>'SUB','from_city'=>'Surabaya','to'=>'KUL','to_city'=>'Kuala Lumpur','dep'=>'14:20','arr'=>'17:45','duration'=>'2j 25m','price'=>890000,'class'=>'Ekonomi','seats'=>12,'stops'=>'Langsung','logo'=>'🌏'],
];

$ACTIVITIES = [
  ['id'=>201,'name'=>'House of Sampoerna Tour','location'=>'Surabaya Utara','category'=>'Wisata Sejarah','rating'=>9.2,'reviews'=>654,'price'=>50000,'duration'=>'2 jam','img_emoji'=>'🏛️','grad'=>'linear-gradient(135deg,#8B4513,#D2691E)','badge'=>'Must Try','desc'=>'Jelajahi museum tembakau bersejarah dan pabrik rokok kuno peninggalan kolonial Belanda.','includes'=>['Pemandu wisata','Akses museum','Cerita bersejarah']],
  ['id'=>202,'name'=>'Wisata Kuliner Surabaya','location'=>'Berbagai Lokasi','category'=>'Food Tour','rating'=>9.5,'reviews'=>1203,'price'=>125000,'duration'=>'3 jam','img_emoji'=>'🍜','grad'=>'linear-gradient(135deg,#E84393,#FF6B35)','badge'=>'Top Pick','desc'=>'Nikmati rawon, lontong balap, rujak cingur, dan kuliner khas Surabaya bersama food guide lokal.','includes'=>['Pemandu lokal','5 tempat makan','Air minum']],
  ['id'=>203,'name'=>'Sunset Cruise Selat Madura','location'=>'Pelabuhan Perak','category'=>'Wisata Bahari','rating'=>8.9,'reviews'=>428,'price'=>250000,'duration'=>'2 jam','img_emoji'=>'🚢','grad'=>'linear-gradient(135deg,#0288D1,#26C6DA)','badge'=>'Romantic','desc'=>'Nikmati sunset memukau di atas kapal mewah sambil menikmati pemandangan kota Surabaya.','includes'=>['Tiket kapal','Snack','Pemandu']],
  ['id'=>204,'name'=>'Escape Room Surabaya','location'=>'Surabaya Pusat','category'=>'Hiburan Indoor','rating'=>9.0,'reviews'=>876,'price'=>95000,'duration'=>'60 menit','img_emoji'=>'🔐','grad'=>'linear-gradient(135deg,#6A1B9A,#AB47BC)','badge'=>'Fun','desc'=>'Uji kecerdasan dan kerja sama tim dalam escape room bertema misteri paling populer di Surabaya.','includes'=>['1 sesi permainan','Locker','Sertifikat']],
];

function rp($n){return 'Rp '.number_format($n,0,',','.');}
function fd($d){return date('d M Y',strtotime($d));}
function fds($d){return date('d M',strtotime($d));}
function rating_label($r){
  if($r>=9.5) return 'Luar Biasa';
  if($r>=9.0) return 'Sempurna';
  if($r>=8.5) return 'Sangat Bagus';
  if($r>=8.0) return 'Bagus';
  return 'Cukup Bagus';
}
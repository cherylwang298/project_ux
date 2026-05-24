const villaDatabase = [
  // --- BATU ---
  {
    id: "v-001",
    name: "Sky View Private Villa",
    type: "Villa & Balcony",
    city: "Batu",
    locationDetail: "Oro-Oro Ombo, Batu (500m dari Jatim Park 2)",
    pricePerNight: 850000, 
    rating: 4.8,
    facilities: ["🏊‍♂️ Pool", "🌅 Balcony", "📶 Wifi"],
    imageUrl: "https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=500",
    mapPosition: { top: '22%', left: '30%' }
  },
  {
    id: "v-002",
    name: "Green Pine Family Homestay",
    type: "Villa Rumah",  
    city: "Batu",
    locationDetail: "Songgokerto, Batu",
    pricePerNight: 620000,
    rating: 4.6,
    facilities: ["👪 Fam Room", "🌳 Garden", "📶 Wifi"],
    imageUrl: "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=500",
    mapPosition: { top: '58%', left: '22%' }
  },
  {
    id: "v-003",
    name: "Amarta Hills Retreat",
    type: "Luxury Resort Villa",  
    city: "Batu",
    locationDetail: "Bumiaji, Batu",
    pricePerNight: 1250000,
    rating: 4.9,
    facilities: ["🏊‍♂️ Pool", "🌅 Balcony", "🛁 Bathtub"],
    imageUrl: "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=500"
  },
  {
    id: "v-004",
    name: "Cozy Apple Lodge",
    type: "Cabin Villa",  
    city: "Batu",
    locationDetail: "Punten, Batu",
    pricePerNight: 450000,
    rating: 4.5,
    facilities: ["🌳 Garden", "📶 Wifi"],
    imageUrl: "https://images.unsplash.com/photo-1449844908441-8829872d2607?w=500"
  },
  {
    id: "v-005",
    name: "Kusuma Estate Villa",
    type: "Private Pool Villa",  
    city: "Batu",
    locationDetail: "Pesanggrahan, Batu",
    pricePerNight: 950000,
    rating: 4.7,
    facilities: ["🏊‍♂️ Pool", "📶 Wifi", "🌳 Garden"],
    imageUrl: "https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=500"
  },

  // --- BALI ---
  {
    id: "v-006",
    name: "Canggu Bliss Luxury Villa",
    type: "Private Pool Villa",
    city: "Bali",
    locationDetail: "Canggu, Bali",
    pricePerNight: 1850000,
    rating: 4.9,
    facilities: ["🏊‍♂️ Pool", "🌅 Balcony", "📶 Wifi"],
    imageUrl: "https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=500",
    mapPosition: { top: '34%', left: '68%' }
    },
  {
    id: "v-007",
    name: "Ubud Jungle Sanctuary",
    type: "Eco Villa",
    city: "Bali",
    locationDetail: "Ubud, Gianyar",
    pricePerNight: 2100000,
    rating: 4.9,
    facilities: ["🏊‍♂️ Pool", "🌳 Garden", "🛁 Bathtub"],
    imageUrl: "https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=500"
  },
  {
    id: "v-008",
    name: "Seminyak Oasis Guest House",
    type: "Boutique Villa",
    city: "Bali",
    locationDetail: "Seminyak, Kuta",
    pricePerNight: 950000,
    rating: 4.7,
    facilities: ["🏊‍♂️ Pool", "📶 Wifi"],
    imageUrl: "https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500"
  },
  {
    id: "v-009",
    name: "Nusa Penida Cliff View",
    type: "Ocean View Villa",
    city: "Bali",
    locationDetail: "Nusa Penida, Bali",
    pricePerNight: 1450000,
    rating: 4.8,
    facilities: ["🌅 Balcony", "📶 Wifi", "🏊‍♂️ Pool"],
    imageUrl: "https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?w=500"
  },
  {
    id: "v-010",
    name: "Uluwatu Surfer's Shack",
    type: "Minimalist Villa",
    city: "Bali",
    locationDetail: "Uluwatu, Bali",
    pricePerNight: 750000,
    rating: 4.6,
    facilities: ["🌅 Balcony", "📶 Wifi"],
    imageUrl: "https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=500"
  },

  // --- BANDUNG ---
  {
    id: "v-011",
    name: "Dago Pakar Highland",
    type: "Modern Villa",
    city: "Bandung",
    locationDetail: "Dago Atas, Bandung",
    pricePerNight: 1600000,
    rating: 4.8,
    facilities: ["🌅 Balcony", "📶 Wifi", "🛁 Bathtub"],
    imageUrl: "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=500"
  },
  {
    id: "v-012",
    name: "Lembang Pine Tree Lodge",
    type: "Wooden Cabin",
    city: "Bandung",
    locationDetail: "Lembang, Bandung Barat",
    pricePerNight: 850000,
    rating: 4.7,
    facilities: ["🌳 Garden", "📶 Wifi", "🌅 Balcony"],
    imageUrl: "https://images.unsplash.com/photo-1542718610-a1d656d1884c?w=500"
  },
  {
    id: "v-013",
    name: "Ciumbuleuit Valley View",
    type: "Family Villa",
    city: "Bandung",
    locationDetail: "Ciumbuleuit, Bandung",
    pricePerNight: 1150000,
    rating: 4.6,
    facilities: ["🏊‍♂️ Pool", "📶 Wifi", "👪 Fam Room"],
    imageUrl: "https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=500"
  },
  {
    id: "v-014",
    name: "Ciwidey Glamping Tent",
    type: "Glamping Villa",
    city: "Bandung",
    locationDetail: "Rancabali, Ciwidey",
    pricePerNight: 550000,
    rating: 4.5,
    facilities: ["🌳 Garden", "🌅 Balcony"],
    imageUrl: "https://images.unsplash.com/photo-1504280390224-dd9427b2e176?w=500"
  },
  {
    id: "v-015",
    name: "Setiabudi Grand Estate",
    type: "Luxury Private Villa",
    city: "Bandung",
    locationDetail: "Setiabudi, Bandung",
    pricePerNight: 2500000,
    rating: 4.9,
    facilities: ["🏊‍♂️ Pool", "🛁 Bathtub", "🌅 Balcony", "📶 Wifi"],
    imageUrl: "https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?w=500"
  }
];

const initialDummyBookings = [
  {
    "villaId": "v-003",
    "checkin": "2026-07-21",
    "checkout": "2026-07-25",
    "guest": "5 Guests",
    "total": "7475000",
    "paymentMethod": "Credit Card",
    "bookedAt": "2026-05-17T17:30:39.480Z"
  },
  {
    "villaId": "v-002",
    "checkin": "2026-07-20",
    "checkout": "2026-07-23",
    "guest": "3 Guests",
    "total": "1935000",
    "paymentMethod": "E-Wallet",
    "bookedAt": "2026-05-18T00:57:46.830Z"
  }
]

const flightDatabase = [

  // SURABAYA -> BALI

  {
    id: "f-001",

    airline: "Garuda Indonesia",

    from: "Surabaya",
    to: "Bali",

    fromAirport: "Soekarno-Hatta",
    toAirport: "Ngurah Rai",

    departureDate: "2026-05-25",

    departureTime: "08:20",
    arrivalTime: "09:35",

    duration: "1j 15m",

    type: "Direct Flight",

    seatClass: "Economy",

    price: 850000,

    rating: 4.9,

    baggage: "20kg",

    imageUrl:
      "https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=600&q=80"
  },

  {
    id: "f-002",

    airline: "Citilink",

    from: "Surabaya",
    to: "Bali",

    fromAirport: "Soekarno-Hatta",
    toAirport: "Ngurah Rai",

    departureDate: "2026-05-25",

    departureTime: "13:10",
    arrivalTime: "14:30",

    duration: "1j 20m",

    type: "Promo",

    seatClass: "Economy",

    price: 720000,

    rating: 4.7,

    baggage: "15kg",

    imageUrl:
      "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600&q=80"
  },

  // JAKARTA -> LOMBOK

  {
    id: "f-003",

    airline: "AirAsia",

    from: "Jakarta",
    to: "Lombok",

    fromAirport: "Soekarno-Hatta",
    toAirport: "Husein Sastranegara",

    departureDate: "2026-05-28",

    departureTime: "06:45",
    arrivalTime: "09:10",

    duration: "2j 25m",

    type: "Best Price",

    seatClass: "Economy",

    price: 1200000,

    rating: 4.8,

    baggage: "20kg",

    imageUrl:
      "https://images.unsplash.com/photo-1517479149777-5f3b1511d5ad?w=600&q=80"
  },

    {
    id: "f-004",

    airline: "AirAsia",

    from: "Lombok",
    to: "Jakarta",

    fromAirport: "Husein Sastranegara",
    toAirport: "Soekarno-Hatta",

    departureDate: "2026-05-30",

    departureTime: "09:45",
    arrivalTime: "12:10",

    duration: "2j 25m",

    type: "Best Price",

    seatClass: "Economy",

    price: 1200000,

    rating: 4.8,

    baggage: "20kg",

    imageUrl:
      "https://images.unsplash.com/photo-1517479149777-5f3b1511d5ad?w=600&q=80"
  },


  // SINGAPORE -> TOKYO

  {
    id: "f-005",

    airline: "Singapore Airlines",

    from: "Singapore",
    to: "Tokyo",

    fromAirport: "Changi",
    toAirport: "Narita",

    departureDate: "2026-06-02",

    departureTime: "23:15",
    arrivalTime: "07:30",

    duration: "7j 15m",

    type: "Best Seller",

    seatClass: "Business",

    price: 4850000,

    rating: 5.0,

    baggage: "30kg",

    imageUrl:
      "https://images.unsplash.com/photo-1540339832862-474599807836?w=600&q=80"
  }

];
  },
  {
    id: "v-004",
    name: "Ubud Rainforest Retreat",
    type: "Resort Villa",
    city: "Bali",
    locationDetail: "Sayan, Ubud, Bali",
    pricePerNight: 2100000,
    rating: 4.9,
    facilities: ["🏊‍♂️ Pool", "🌳 Garden", "📶 Wifi"],
    imageUrl: "https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=500",
    mapPosition: { top: '40%', left: '60%' }
  },
  {
    id: "v-005",
    name: "Seminyak Sun & Surf Villa",
    type: "Private Pool Villa",
    city: "Bali",
    locationDetail: "Seminyak, Kuta, Bali",
    pricePerNight: 1650000,
    rating: 4.7,
    facilities: ["🏊‍♂️ Pool", "🌅 Balcony", "📶 Wifi"],
    imageUrl: "https://images.unsplash.com/photo-1512915922686-57c11dde9b6b?w=500",
    mapPosition: { top: '45%', left: '65%' }
  },
  {
    id: "v-006",
    name: "Alpine Wooden Chalet",
    type: "Cabin Villa",
    city: "Batu",
    locationDetail: "Bumiaji, Batu",
    pricePerNight: 950000,
    rating: 4.5,
    facilities: ["🔥 Fireplace", "🌳 Garden", "📶 Wifi"],
    imageUrl: "https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=500",
    mapPosition: { top: '15%', left: '35%' }
  },
  {
    id: "v-007",
    name: "Nusa Dua Cliffside Mansion",
    type: "Luxury Ocean Villa",
    city: "Bali",
    locationDetail: "Nusa Dua, Bali",
    pricePerNight: 3500000,
    rating: 5.0,
    facilities: ["🏊‍♂️ Pool", "🌅 Balcony", "🚗 Parking"],
    imageUrl: "https://images.unsplash.com/photo-1583037189850-1921ae7c6c22?w=500",
    mapPosition: { top: '55%', left: '75%' }
  },
  {
    id: "v-008",
    name: "Hilltop Vista Homestay",
    type: "Family Villa",
    city: "Batu",
    locationDetail: "Sisir, Batu",
    pricePerNight: 750000,
    rating: 4.4,
    facilities: ["👪 Fam Room", "🌅 Balcony", "📶 Wifi"],
    imageUrl: "https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?w=500",
    mapPosition: { top: '30%', left: '28%' }
  }
];

// Data 10 Hotel
const hotelDatabase = [
  {
    id: "h-001",
    name: "The Grand Palace Hotel",
    type: "Luxury Hotel",
    city: "Surabaya",
    locationDetail: "Genteng, Surabaya Pusat",
    pricePerNight: 1200000,
    rating: 4.8,
    facilities: ["🏊‍♂️ Pool", "🏋️‍♂️ Gym", "🍳 Breakfast"],
    imageUrl: "https://images.unsplash.com/photo-1566073771259-6a8506099945?w=500",
    mapPosition: { top: '35%', left: '50%' }
  },
  {
    id: "h-002",
    name: "Neo Horizon Business Hotel",
    type: "Business Hotel",
    city: "Surabaya",
    locationDetail: "Gubeng, Surabaya",
    pricePerNight: 650000,
    rating: 4.5,
    facilities: ["💻 Meeting Rm", "🍳 Breakfast", "📶 Wifi"],
    imageUrl: "https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=500",
    mapPosition: { top: '42%', left: '55%' }
  },
  {
    id: "h-003",
    name: "Batu Heritage Resort & Hotel",
    type: "Boutique Hotel",
    city: "Batu",
    locationDetail: "Sisir, Kota Batu",
    pricePerNight: 890000,
    rating: 4.6,
    facilities: ["🏊‍♂️ Pool", "🌳 Garden", "🍳 Breakfast"],
    imageUrl: "https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=500",
    mapPosition: { top: '25%', left: '25%' }
  },
  {
    id: "h-004",
    name: "Kuta Beachfront Inn",
    type: "Budget Hotel",
    city: "Bali",
    locationDetail: "Kuta, Bali",
    pricePerNight: 450000,
    rating: 4.2,
    facilities: ["🏖️ Beach Access", "📶 Wifi", "🚗 Parking"],
    imageUrl: "https://images.unsplash.com/photo-1543968996-ee822b8176ba?w=500",
    mapPosition: { top: '50%', left: '62%' }
  },
  {
    id: "h-005",
    name: "The Urban Stay",
    type: "Minimalist Hotel",
    city: "Surabaya",
    locationDetail: "Wonokromo, Surabaya",
    pricePerNight: 380000,
    rating: 4.3,
    facilities: ["📶 Wifi", "☕ Cafe", "🚗 Parking"],
    imageUrl: "https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?w=500",
    mapPosition: { top: '50%', left: '48%' }
  },
  {
    id: "h-006",
    name: "Golden Tulip Skyline",
    type: "Luxury Hotel",
    city: "Batu",
    locationDetail: "Oro-Oro Ombo, Batu",
    pricePerNight: 1350000,
    rating: 4.7,
    facilities: ["🏊‍♂️ Pool", "🏋️‍♂️ Gym", "🌅 Balcony"],
    imageUrl: "https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=500",
    mapPosition: { top: '23%', left: '32%' }
  },
  {
    id: "h-007",
    name: "Sanur Serenity Resort",
    type: "Wellness Hotel",
    city: "Bali",
    locationDetail: "Sanur, Bali",
    pricePerNight: 1500000,
    rating: 4.8,
    facilities: ["🏊‍♂️ Pool", "🧘‍♂️ Yoga Deck", "🍳 Breakfast"],
    imageUrl: "https://images.unsplash.com/photo-1564507592333-c60657eea523?w=500",
    mapPosition: { top: '48%', left: '72%' }
  },
  {
    id: "h-008",
    name: "Spark Smart Hotel",
    type: "Transit Hotel",
    city: "Surabaya",
    locationDetail: "Juanda, Sidoarjo (Dekat Bandara)",
    pricePerNight: 320000,
    rating: 4.1,
    facilities: ["📶 Wifi", "🚌 Shuttle", "🚗 Parking"],
    imageUrl: "https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=500",
    mapPosition: { top: '65%', left: '52%' }
  },
  {
    id: "h-009",
    name: "The Ritz Signature",
    type: "5-Star Premium Hotel",
    city: "Bali",
    locationDetail: "Jimbaran, Bali",
    pricePerNight: 4200000,
    rating: 4.9,
    facilities: ["🏊‍♂️ Pool", "🏋️‍♂️ Gym", "🏖️ Beach Access"],
    imageUrl: "https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=500",
    mapPosition: { top: '58%', left: '64%' }
  },
  {
    id: "h-010",
    name: "Eco Green Boutique Hotel",
    type: "Eco Hotel",
    city: "Batu",
    locationDetail: "Songgokerto, Batu",
    pricePerNight: 580000,
    rating: 4.4,
    facilities: ["🌳 Garden", "📶 Wifi", "☕ Cafe"],
    imageUrl: "https://images.unsplash.com/photo-1582719508461-905c673771fd?w=500",
    mapPosition: { top: '60%', left: '20%' }
  }
];

// Data 10 Apartment
const apartmentDatabase = [
  {
    id: "a-001",
    name: "Grand Pakuwon Residence",
    type: "Studio Apartment",
    city: "Surabaya",
    locationDetail: "Pakuwon Indah, Surabaya Barat",
    pricePerNight: 550000,
    rating: 4.6,
    facilities: ["🏊‍♂️ Pool", "📶 Wifi", "🍳 Kitchenette"],
    imageUrl: "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=500",
    mapPosition: { top: '38%', left: '42%' }
  },
  {
    id: "a-002",
    name: "Tunjungan Plaza Heights",
    type: "2BR Premium Apartment",
    city: "Surabaya",
    locationDetail: "Tegalsari, Surabaya Pusat",
    pricePerNight: 980000,
    rating: 4.8,
    facilities: ["🏊‍♂️ Pool", "🌅 Balcony", "🏋️‍♂️ Gym"],
    imageUrl: "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=500",
    mapPosition: { top: '36%', left: '51%' }
  },
  {
    id: "a-003",
    name: "Batu Panorama Studio",
    type: "Mountain View Condo",
    city: "Batu",
    locationDetail: "Sisir, Kota Batu",
    pricePerNight: 480000,
    rating: 4.4,
    facilities: ["🌅 Balcony", "📶 Wifi", "🍳 Kitchenette"],
    imageUrl: "https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=500",
    mapPosition: { top: '28%', left: '26%' }
  },
  {
    id: "a-004",
    name: "Canggu Loft & Studio",
    type: "Loft Apartment",
    city: "Bali",
    locationDetail: "Canggu, Bali",
    pricePerNight: 850000,
    rating: 4.7,
    facilities: ["🏊‍♂️ Pool", "📶 Wifi", "🍳 Kitchenette"],
    imageUrl: "https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=500",
    mapPosition: { top: '36%', left: '67%' }
  },
  {
    id: "a-005",
    name: " Ciputra World Orbit",
    type: "1BR Modern Apartment",
    city: "Surabaya",
    locationDetail: "Mayjen Sungkono, Surabaya",
    pricePerNight: 700000,
    rating: 4.5,
    facilities: ["🏊‍♂️ Pool", "🏋️‍♂️ Gym", "📶 Wifi"],
    imageUrl: "https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=500",
    mapPosition: { top: '45%', left: '45%' }
  },
  {
    id: "a-006",
    name: "Gunawangsa Merr Co-Living",
    type: "Budget Studio",
    city: "Surabaya",
    locationDetail: "Rungkut, Surabaya Timur",
    pricePerNight: 300000,
    rating: 4.2,
    facilities: ["🏊‍♂️ Pool", "📶 Wifi", "🚗 Parking"],
    imageUrl: "https://images.unsplash.com/photo-1505691938895-1758d7feb511?w=500",
    mapPosition: { top: '55%', left: '58%' }
  },
  {
    id: "a-007",
    name: "De溫暖 Batu Apartment",
    type: "Family Suite Condo",
    city: "Batu",
    locationDetail: "Oro-Oro Ombo, Batu",
    pricePerNight: 650000,
    rating: 4.5,
    facilities: ["👪 Fam Room", "🌅 Balcony", "📶 Wifi"],
    imageUrl: "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=500",
    mapPosition: { top: '24%', left: '31%' }
  },
  {
    id: "a-008",
    name: "Seminyak Urban Lofts",
    type: "Studio Apartment",
    city: "Bali",
    locationDetail: "Seminyak, Bali",
    pricePerNight: 900000,
    rating: 4.6,
    facilities: ["🏊‍♂️ Pool", "📶 Wifi", "🍳 Kitchenette"],
    imageUrl: "https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=500",
    mapPosition: { top: '44%', left: '66%' }
  },
  {
    id: "a-009",
    name: "Educity Stanford Suite",
    type: "Student Studio",
    city: "Surabaya",
    locationDetail: "Mulyorejo, Surabaya Timur",
    pricePerNight: 320000,
    rating: 4.3,
    facilities: ["🏊‍♂️ Pool", "📶 Wifi", " Laundry"],
    imageUrl: "https://images.unsplash.com/photo-1554995207-c18c203602cb?w=500",
    mapPosition: { top: '35%', left: '60%' }
  },
  {
    id: "a-010",
    name: "The Peak Penthouse",
    type: "Luxury Penthouse",
    city: "Surabaya",
    locationDetail: "Embong Malang, Surabaya Pusat",
    pricePerNight: 2500000,
    rating: 4.9,
    facilities: ["🏊‍♂️ Pool", "🌅 Balcony", "🏋️‍♂️ Gym"],
    imageUrl: "https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?w=500",
    mapPosition: { top: '37%', left: '49%' }
  }
];

const allDatabase = [...villaDatabase, ...hotelDatabase, ...apartmentDatabase];

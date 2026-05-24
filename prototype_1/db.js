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
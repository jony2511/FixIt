<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $plumbing = Category::where('slug', 'plumbing')->first();
        $electrical = Category::where('slug', 'electrical')->first();
        $hvac = Category::where('slug', 'hvac')->first();
        $carpentry = Category::where('slug', 'carpentry')->first();
        $painting = Category::where('slug', 'painting')->first();

        $products = [
            // Plumbing Products
            [
                'name' => 'Heavy Duty Pipe Wrench Set',
                'description' => 'Professional grade pipe wrench set with 3 different sizes (10", 14", 18"). Perfect for plumbing repairs and installations. Heat-treated carbon steel construction with comfortable non-slip grip handles.',
                'category_id' => $plumbing?->id,
                'price' => 89.99,
                'quantity' => 25,
                'brand' => 'Stanley',
                'warranty' => 'Lifetime Manufacturer Warranty',
                'stock_status' => 'in_stock',
            ],
            [
                'name' => 'Faucet Repair Kit - Universal',
                'description' => 'Complete faucet repair kit includes O-rings, washers, screws, and valve stems. Compatible with most standard faucet brands. Everything you need for quick faucet repairs.',
                'category_id' => $plumbing?->id,
                'price' => 24.99,
                'quantity' => 50,
                'brand' => 'Danco',
                'warranty' => '1 Year Warranty',
                'stock_status' => 'in_stock',
            ],
            [
                'name' => 'PVC Pipe Cutter',
                'description' => 'Quick and clean cuts for PVC, CPVC, and PE pipe up to 1-5/8 inches in diameter. Spring-loaded design with ratcheting mechanism for easy one-handed operation.',
                'category_id' => $plumbing?->id,
                'price' => 19.99,
                'quantity' => 8,
                'brand' => 'Ridgid',
                'warranty' => '2 Year Warranty',
                'stock_status' => 'low_stock',
            ],
            [
                'name' => 'Toilet Fill Valve - QuietFill',
                'description' => 'Universal toilet fill valve with noise-reducing design. Easy installation without tools. Adjustable height fits most toilets. Water-saving certified.',
                'category_id' => $plumbing?->id,
                'price' => 15.99,
                'quantity' => 35,
                'brand' => 'Fluidmaster',
                'warranty' => '5 Year Warranty',
                'stock_status' => 'in_stock',
            ],

            // Electrical Products
            [
                'name' => 'Digital Multimeter - Professional',
                'description' => 'Auto-ranging digital multimeter with True RMS. Measures AC/DC voltage, current, resistance, capacitance, frequency, duty cycle, and temperature. Built-in non-contact voltage detector.',
                'category_id' => $electrical?->id,
                'price' => 79.99,
                'quantity' => 15,
                'brand' => 'Fluke',
                'warranty' => '3 Year Manufacturer Warranty',
                'stock_status' => 'in_stock',
            ],
            [
                'name' => 'Wire Stripper & Crimper Tool',
                'description' => 'Professional 8-in-1 multi-function wire tool. Strips, cuts, and crimps wires from 10-22 AWG. Ergonomic handles with spring-loaded design for reduced hand fatigue.',
                'category_id' => $electrical?->id,
                'price' => 34.99,
                'quantity' => 22,
                'brand' => 'Klein Tools',
                'warranty' => 'Lifetime Warranty',
                'stock_status' => 'in_stock',
            ],
            [
                'name' => 'LED Light Bulbs - 60W Equivalent (12 Pack)',
                'description' => 'Energy-efficient LED bulbs, 9W (60W equivalent), 800 lumens, 2700K warm white. Dimmable, 25,000 hour lifespan. Saves up to 85% on energy costs.',
                'category_id' => $electrical?->id,
                'price' => 29.99,
                'quantity' => 100,
                'brand' => 'Philips',
                'warranty' => '3 Year Warranty',
                'stock_status' => 'in_stock',
            ],
            [
                'name' => 'Circuit Breaker - 20 Amp Single Pole',
                'description' => 'Standard 20A single pole circuit breaker. UL listed, thermal-magnetic trip unit. Compatible with most residential electrical panels. Easy plug-in installation.',
                'category_id' => $electrical?->id,
                'price' => 12.99,
                'quantity' => 45,
                'brand' => 'Square D',
                'warranty' => '1 Year Warranty',
                'stock_status' => 'in_stock',
            ],
            [
                'name' => 'Voltage Tester - Non-Contact',
                'description' => 'Non-contact voltage tester pen with LED and audible alerts. Detects AC voltage from 90V to 1000V. Pocket clip and batteries included. Essential safety tool.',
                'category_id' => $electrical?->id,
                'price' => 14.99,
                'quantity' => 30,
                'brand' => 'Klein Tools',
                'warranty' => '2 Year Warranty',
                'stock_status' => 'in_stock',
            ],

            // HVAC Products
            [
                'name' => 'HVAC Air Filter - MERV 13 (6 Pack)',
                'description' => '16x25x1 pleated air filter 6-pack. MERV 13 rating captures 98% of airborne particles. Electrostatic charge attracts microscopic particles. Lasts up to 90 days.',
                'category_id' => $hvac?->id,
                'price' => 59.99,
                'quantity' => 40,
                'brand' => 'Filtrete',
                'warranty' => 'Satisfaction Guaranteed',
                'stock_status' => 'in_stock',
            ],
            [
                'name' => 'Digital Thermostat - Programmable',
                'description' => '7-day programmable thermostat with backlit display. 4 program periods per day. Energy Star certified. Easy DIY installation with step-by-step guide.',
                'category_id' => $hvac?->id,
                'price' => 49.99,
                'quantity' => 18,
                'brand' => 'Honeywell',
                'warranty' => '5 Year Warranty',
                'stock_status' => 'in_stock',
            ],
            [
                'name' => 'Refrigerant Gauge Set - R410A',
                'description' => 'Professional 4-way manifold gauge set for R410A refrigerant. Color-coded hoses, brass fittings, carrying case included. Accurate pressure readings.',
                'category_id' => $hvac?->id,
                'price' => 129.99,
                'quantity' => 7,
                'brand' => 'Yellow Jacket',
                'warranty' => '2 Year Warranty',
                'stock_status' => 'low_stock',
            ],

            // Carpentry Products
            [
                'name' => 'Cordless Drill Driver Kit - 20V',
                'description' => '20V MAX cordless drill/driver with 2 batteries, charger, and carrying case. 1/2" keyless chuck, 2-speed transmission (0-450/1,500 RPM), LED work light.',
                'category_id' => $carpentry?->id,
                'price' => 149.99,
                'quantity' => 12,
                'brand' => 'DeWalt',
                'warranty' => '3 Year Limited Warranty',
                'stock_status' => 'in_stock',
            ],
            [
                'name' => 'Carpenter\'s Tool Belt - Premium Leather',
                'description' => 'Heavy-duty genuine leather tool belt with multiple pockets and hammer loop. Adjustable size fits 29"-46" waist. Reinforced stitching for durability.',
                'category_id' => $carpentry?->id,
                'price' => 79.99,
                'quantity' => 20,
                'brand' => 'Occidental Leather',
                'warranty' => 'Lifetime Warranty',
                'stock_status' => 'in_stock',
            ],
            [
                'name' => 'Wood Chisel Set - 6 Piece',
                'description' => 'Professional wood chisel set with sizes 1/4", 1/2", 3/4", 1", 1-1/4", 1-1/2". Chrome vanadium steel blades, hardwood handles. Includes storage case.',
                'category_id' => $carpentry?->id,
                'price' => 44.99,
                'quantity' => 15,
                'brand' => 'Irwin',
                'warranty' => 'Lifetime Warranty',
                'stock_status' => 'in_stock',
            ],
            [
                'name' => 'Circular Saw - 15 Amp',
                'description' => '15 Amp circular saw with 7-1/4" blade. 5,300 RPM, 57° bevel capacity. Electric brake, dust blower, rip fence included. Lightweight magnesium construction.',
                'category_id' => $carpentry?->id,
                'price' => 119.99,
                'quantity' => 9,
                'brand' => 'Makita',
                'warranty' => '1 Year Warranty',
                'stock_status' => 'low_stock',
            ],

            // Painting Products
            [
                'name' => 'Paint Roller Kit - Professional',
                'description' => 'Complete paint roller kit with 9" roller frame, 3 premium microfiber roller covers, paint tray, and tray liner. For smooth to semi-smooth surfaces.',
                'category_id' => $painting?->id,
                'price' => 32.99,
                'quantity' => 35,
                'brand' => 'Purdy',
                'warranty' => '90 Day Warranty',
                'stock_status' => 'in_stock',
            ],
            [
                'name' => 'Paint Brush Set - Premium (5 Piece)',
                'description' => 'Professional paint brush set with angled and flat brushes (1", 1.5", 2", 2.5", 3"). Synthetic bristles for all paint types. Comfortable grip handles.',
                'category_id' => $painting?->id,
                'price' => 39.99,
                'quantity' => 28,
                'brand' => 'Wooster',
                'warranty' => '1 Year Warranty',
                'stock_status' => 'in_stock',
            ],
            [
                'name' => 'Paint Sprayer - Airless',
                'description' => 'Airless paint sprayer for interior/exterior projects. 0.27 GPM flow rate, adjustable pressure control, 25 ft hose. Includes 2 spray tips and cleaning kit.',
                'category_id' => $painting?->id,
                'price' => 199.99,
                'quantity' => 6,
                'brand' => 'Graco',
                'warranty' => '2 Year Warranty',
                'stock_status' => 'low_stock',
            ],
            [
                'name' => 'Painter\'s Tape - Blue (6 Pack)',
                'description' => 'Professional grade painter\'s tape, 1.41" x 60 yards per roll (6 pack). Clean removal up to 14 days, UV resistant. Sharp paint lines every time.',
                'category_id' => $painting?->id,
                'price' => 24.99,
                'quantity' => 60,
                'brand' => '3M ScotchBlue',
                'warranty' => 'Satisfaction Guaranteed',
                'stock_status' => 'in_stock',
            ],
            [
                'name' => 'Drop Cloth - Canvas (9x12 ft)',
                'description' => 'Heavy-duty canvas drop cloth, 9x12 feet. Absorbs paint spills, protects floors and furniture. Machine washable and reusable. Professional quality.',
                'category_id' => $painting?->id,
                'price' => 34.99,
                'quantity' => 25,
                'brand' => 'CCS Chicago Canvas',
                'warranty' => 'None',
                'stock_status' => 'in_stock',
            ],
        ];

        foreach ($products as $product) {
            if ($product['category_id']) {
                Product::create($product);
            }
        }
    }
}

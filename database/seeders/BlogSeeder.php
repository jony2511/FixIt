<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first admin user as author
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            $admin = User::first();
        }

        $blogs = [
            [
                'title' => 'Common Home Appliance Problems and Quick Fixes',
                'excerpt' => 'Learn about the most common home appliance issues and how to troubleshoot them before calling for professional help.',
                'content' => '<p>Home appliances are essential to our daily lives, but they can sometimes malfunction. Understanding common problems can save you time and money.</p>
                
                <h3>Refrigerator Not Cooling</h3>
                <p>If your refrigerator isn\'t cooling properly, check the temperature settings first. Ensure the vents aren\'t blocked and the door seals are clean and intact. Clean the condenser coils regularly to maintain efficiency.</p>
                
                <h3>Washing Machine Not Draining</h3>
                <p>A washing machine that won\'t drain usually has a clogged drain pump filter or kinked drain hose. Check and clean the filter, and ensure the drain hose is properly positioned.</p>
                
                <h3>Microwave Not Heating</h3>
                <p>If your microwave runs but doesn\'t heat, the magnetron might be faulty. This requires professional repair. However, first check if the door closes properly and the turntable rotates.</p>
                
                <p>For any persistent issues, contact FixIt Solutions for professional diagnosis and repair services. Our certified technicians are ready to help!</p>',
                'category' => 'Repair Tips',
                'author_id' => $admin->id,
                'views' => 156,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'How to Maintain Your AC for Optimal Performance',
                'excerpt' => 'Regular AC maintenance can extend its lifespan and improve efficiency. Follow these essential tips to keep your air conditioner running smoothly.',
                'content' => '<p>Air conditioning maintenance is crucial for ensuring comfort and energy efficiency in your home. Here are essential maintenance tips:</p>
                
                <h3>Clean or Replace Filters Monthly</h3>
                <p>Dirty filters restrict airflow and reduce efficiency. Clean reusable filters or replace disposable ones every 1-3 months, especially during peak usage seasons.</p>
                
                <h3>Keep the Outdoor Unit Clear</h3>
                <p>Remove debris, leaves, and vegetation from around your outdoor unit. Maintain at least 2 feet of clearance for proper airflow. Gently clean the fins with a soft brush.</p>
                
                <h3>Check Thermostat Settings</h3>
                <p>Ensure your thermostat is working correctly and set at the appropriate temperature. Consider upgrading to a programmable thermostat for better energy management.</p>
                
                <h3>Professional Maintenance</h3>
                <p>Schedule annual professional maintenance with FixIt Solutions. Our technicians will check refrigerant levels, inspect electrical components, and ensure optimal performance.</p>
                
                <p>Don\'t wait until your AC breaks down. Regular maintenance prevents costly repairs and extends your system\'s lifespan. Contact us today to schedule your service!</p>',
                'category' => 'Maintenance',
                'author_id' => $admin->id,
                'views' => 203,
                'published_at' => now()->subDays(12),
            ],
            [
                'title' => 'Smart Home Integration: Modernizing Your Appliances',
                'excerpt' => 'Discover how smart home technology can transform your existing appliances and improve your daily life with automation and remote control.',
                'content' => '<p>Smart home technology is revolutionizing how we interact with our appliances. Even if you don\'t have the latest smart appliances, you can still enjoy automation benefits.</p>
                
                <h3>Smart Plugs for Any Appliance</h3>
                <p>Smart plugs can turn any appliance into a connected device. Control lamps, fans, coffee makers, and more from your smartphone. Set schedules and monitor energy usage.</p>
                
                <h3>Smart Thermostats</h3>
                <p>Upgrade to a smart thermostat to control your HVAC system remotely. Learn your preferences, adjust based on weather, and can save up to 20% on energy bills.</p>
                
                <h3>Voice Control Integration</h3>
                <p>Connect your smart devices to Amazon Alexa or Google Assistant for hands-free control. "Alexa, turn on the living room fan" makes life more convenient.</p>
                
                <h3>Energy Monitoring</h3>
                <p>Smart home systems provide detailed energy usage reports. Identify energy-hungry appliances and optimize your consumption to reduce electricity bills.</p>
                
                <p>FixIt Solutions offers smart home integration services. Our experts can help you choose and install the right smart devices for your home. Get a free consultation today!</p>',
                'category' => 'Technology',
                'author_id' => $admin->id,
                'views' => 89,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => '5 Signs Your Water Heater Needs Immediate Attention',
                'excerpt' => 'Don\'t ignore these warning signs! Learn when your water heater needs professional service to prevent complete failure and water damage.',
                'content' => '<p>Your water heater works hard every day, but like all appliances, it can develop problems. Here are critical warning signs you shouldn\'t ignore:</p>
                
                <h3>1. Rusty or Discolored Water</h3>
                <p>If you notice rusty water from your hot water tap, your water heater tank may be corroding from the inside. This is a serious issue that requires immediate professional attention.</p>
                
                <h3>2. Strange Noises</h3>
                <p>Rumbling, popping, or banging sounds indicate sediment buildup in the tank. This reduces efficiency and can lead to tank damage if not addressed promptly.</p>
                
                <h3>3. Water Pooling Around the Unit</h3>
                <p>Any moisture or water around your water heater could indicate a leak. This is an emergency situation that needs immediate professional repair to prevent flooding.</p>
                
                <h3>4. Inconsistent Water Temperature</h3>
                <p>If your water temperature fluctuates or you\'re running out of hot water quickly, the heating element or thermostat may be failing.</p>
                
                <h3>5. Age Over 10 Years</h3>
                <p>Water heaters typically last 8-12 years. If yours is approaching or exceeding this age, consider replacement before it fails completely.</p>
                
                <p>FixIt Solutions provides emergency water heater services 24/7. Don\'t risk water damage or cold showers – call us immediately if you notice any of these signs!</p>',
                'category' => 'Repair Tips',
                'author_id' => $admin->id,
                'views' => 142,
                'published_at' => now()->subDays(8),
            ],
            [
                'title' => 'Energy-Saving Tips for Your Home Appliances',
                'excerpt' => 'Reduce your electricity bills and environmental impact with these practical energy-saving strategies for everyday appliances.',
                'content' => '<p>Energy efficiency isn\'t just good for the environment – it also saves you money. Here are practical tips to reduce your appliance energy consumption:</p>
                
                <h3>Refrigerator Efficiency</h3>
                <p>Keep your refrigerator at 37-40°F and freezer at 0-5°F. Don\'t overcrowd the fridge, as it needs air circulation. Clean the coils every 6 months and ensure door seals are tight.</p>
                
                <h3>Laundry Best Practices</h3>
                <p>Wash clothes in cold water when possible – it uses 90% less energy than hot water. Run full loads only, and clean the lint filter after every dryer use. Consider air-drying when weather permits.</p>
                
                <h3>Dishwasher Efficiency</h3>
                <p>Run your dishwasher only when full. Use the energy-saving or eco mode if available. Skip the heated dry cycle and let dishes air dry instead.</p>
                
                <h3>HVAC Optimization</h3>
                <p>Set your thermostat to 78°F in summer and 68°F in winter. Use ceiling fans to improve air circulation. Change filters regularly and schedule annual maintenance.</p>
                
                <h3>Unplug Phantom Loads</h3>
                <p>Electronics and appliances draw power even when off. Unplug chargers, coffee makers, and other devices when not in use, or use power strips you can easily switch off.</p>
                
                <p>Need help optimizing your appliances for energy efficiency? FixIt Solutions offers energy audits and appliance optimization services. Contact us to start saving today!</p>',
                'category' => 'Energy Efficiency',
                'author_id' => $admin->id,
                'views' => 178,
                'published_at' => now()->subDays(15),
            ],
            [
                'title' => 'DIY vs Professional Repair: When to Call the Experts',
                'excerpt' => 'Not sure whether to tackle an appliance repair yourself or call a professional? This guide helps you make the right decision.',
                'content' => '<p>While DIY repairs can save money, some situations require professional expertise. Here\'s how to decide:</p>
                
                <h3>Safe DIY Repairs</h3>
                <p><strong>You can handle:</strong> Replacing refrigerator water filters, cleaning dryer vents, replacing vacuum belts, cleaning dishwasher filters, and unclogging drains with basic tools.</p>
                
                <h3>When to Call a Professional</h3>
                <p><strong>Get expert help for:</strong> Gas appliance repairs, electrical issues beyond simple plug replacements, refrigerant handling, major component replacements, and warranty-covered repairs.</p>
                
                <h3>Safety Considerations</h3>
                <p>Never attempt repairs involving gas lines, high voltage electricity, or refrigerants. These require special training, tools, and certifications. The risk of injury or property damage is too high.</p>
                
                <h3>Cost-Benefit Analysis</h3>
                <p>Consider the appliance\'s age and repair cost. If repair costs exceed 50% of replacement value, or the appliance is near end-of-life, replacement might be more economical.</p>
                
                <h3>Warranty Protection</h3>
                <p>DIY repairs can void manufacturer warranties. Always check warranty terms before attempting repairs yourself.</p>
                
                <p>FixIt Solutions offers free diagnostic consultations. We\'ll honestly assess whether repair or replacement is your best option. Our certified technicians handle all appliance brands and models. Call us today!</p>',
                'category' => 'Repair Tips',
                'author_id' => $admin->id,
                'views' => 234,
                'published_at' => now()->subDays(20),
            ],
        ];

        foreach ($blogs as $blogData) {
            Blog::create($blogData);
        }
    }
}

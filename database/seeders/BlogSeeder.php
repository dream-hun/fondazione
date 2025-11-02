<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some featured blog posts
        \App\Models\Blog::factory()->published()->featured()->create([
            'title' => 'Empowering Women Through Microfinance: A Success Story from Huye',
            'excerpt' => 'Discover how our microfinance program has transformed the lives of women entrepreneurs in rural Rwanda, creating sustainable livelihoods and strengthening communities.',
            'content' => 'In the rolling hills of Huye district, a quiet revolution is taking place. Through our microfinance program, women who once struggled to make ends meet are now thriving entrepreneurs, supporting their families and contributing to their communities.

Grace Mukamana, a 34-year-old mother of three, exemplifies this transformation. Just two years ago, she was struggling to feed her family on her husband\'s modest farming income. Today, she runs a successful tailoring business that employs five other women from her village.

"When I first heard about the microfinance program, I was skeptical," Grace recalls. "I had never run a business before, and I didn\'t think anyone would trust me with a loan." But with the support of our local coordinators and comprehensive business training, Grace took her first loan of 50,000 RWF to purchase a sewing machine and basic supplies.

The program goes beyond just providing capital. Participants receive training in business management, financial literacy, and marketing. They also join support groups where they can share experiences, challenges, and solutions with other women entrepreneurs.

Within six months, Grace had repaid her first loan and was ready to expand. Her second loan allowed her to purchase additional equipment and rent a small shop in the local market. Word of her quality work spread quickly, and soon she had more orders than she could handle alone.

"That\'s when I decided to hire other women," Grace explains. "I remembered how difficult it was when I had no income, and I wanted to help others in the same situation." Today, her workshop buzzes with activity as six women work together, creating school uniforms, traditional dresses, and modern clothing for customers throughout the district.

The impact extends far beyond individual success stories. The women employed by Grace can now afford to send their children to school, access healthcare, and invest in their homes. The increased economic activity has also benefited the broader community, with local suppliers and service providers seeing increased business.

Our microfinance program has reached over 2,000 women across five districts, with a repayment rate of 98%. But the numbers only tell part of the story. The real measure of success is in the confidence these women have gained, the leadership roles they\'ve taken in their communities, and the example they\'re setting for the next generation.',
            'author_name' => 'Sarah Uwimana',
            'author_email' => 'sarah@ngoplatform.org',
            'tags' => 'microfinance, women empowerment, entrepreneurship, Rwanda, success stories',
            'reading_time' => 8,
        ]);

        \App\Models\Blog::factory()->published()->featured()->create([
            'title' => 'Clean Water Changes Everything: The Transformation of Nyamirambo Village',
            'excerpt' => 'Follow the incredible journey of how a simple water project brought health, education, and hope to an entire community in rural Rwanda.',
            'content' => 'Water is life. This simple truth became profoundly clear during our recent visit to Nyamirambo village, where a community water project has transformed not just access to clean water, but the entire fabric of village life.

Before the project began in 2022, the 800 residents of Nyamirambo faced a daily struggle that consumed hours and endangered health. Women and children would walk up to 5 kilometers each way to collect water from a contaminated source, carrying heavy jerrycans on their heads under the scorching sun.

The transformation began the moment clean water started flowing. Children who once spent mornings collecting water were now in school by 7 AM. Girls\' enrollment increased by 85% in the first year alone. Teachers reported improved concentration and academic performance as students were no longer exhausted from water collection duties.

Health improvements were equally dramatic. Cases of diarrheal diseases dropped by 70% within six months. The local health center, which once saw dozens of waterborne illness cases weekly, now focuses on preventive care and other health needs.',
            'author_name' => 'Jean Claude Habimana',
            'author_email' => 'jean@ngoplatform.org',
            'tags' => 'clean water, community development, health, education, rural development',
            'reading_time' => 6,
        ]);

        \App\Models\Blog::factory()->published()->featured()->create([
            'title' => 'From Dropout to Graduate: How Education Support Changed Marie\'s Life',
            'excerpt' => 'Meet Marie Uwimana, whose journey from school dropout to university graduate showcases the transformative power of educational support and community investment.',
            'content' => 'Education is the most powerful weapon which you can use to change the world. Nelson Mandela\'s words ring especially true in the story of Marie Uwimana, whose educational journey embodies the transformative power of opportunity and support.

Three years ago, Marie was a 16-year-old school dropout living in Musanze district. Her father had died when she was 12, leaving her mother to care for five children on a small farm. When the family could no longer afford school fees, Marie was the first to leave school, despite being one of the brightest students in her class.

That\'s when our education support program reached Musanze. Working with local schools and community leaders, we identify bright students from vulnerable families who have dropped out or are at risk of leaving school. Marie was among the first beneficiaries.

The program provides more than just school fees. Students receive uniforms, books, meals, and most importantly, mentorship and counseling support. We also work with families to address the underlying issues that threaten educational continuity.

Marie\'s academic performance was exceptional. She consistently ranked among the top students in her class and became a peer tutor for other struggling students. Her confidence grew, and she began to see herself not just as a beneficiary, but as a leader and role model.',
            'author_name' => 'Agnes Mukamana',
            'author_email' => 'agnes@ngoplatform.org',
            'tags' => 'education, youth empowerment, scholarships, success stories, girls education',
            'reading_time' => 7,
        ]);

        // Create additional regular blog posts
        \App\Models\Blog::factory()->published()->count(12)->create();

        // Create some draft posts
        \App\Models\Blog::factory()->draft()->count(3)->create();
    }
}

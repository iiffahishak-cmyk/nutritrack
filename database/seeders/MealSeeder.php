<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meal;

class MealSeeder extends Seeder
{
    public function run(): void
    {
        $meals = [

            // ═══════════════════════════════
            // BREAKFAST MEALS
            // ═══════════════════════════════

            // --- Malay ---
            ['meal_name' => 'Nasi Lemak',          'description' => 'Coconut rice with sambal, egg and anchovies',       'calories' => 400, 'protein' => 12, 'carbs' => 55, 'fat' => 16, 'meal_time' => 'Breakfast', 'cuisine_type' => 'Malay',       'ingredients' => 'rice, coconut milk, anchovies, egg, peanuts, sambal'],
            ['meal_name' => 'Nasi Dagang',          'description' => 'Rice cooked in coconut milk with fish curry',       'calories' => 400, 'protein' => 18, 'carbs' => 52, 'fat' => 14, 'meal_time' => 'Breakfast', 'cuisine_type' => 'Malay',       'ingredients' => 'rice, coconut milk, fish, fenugreek, shallots'],
            ['meal_name' => 'Bubur Nasi',           'description' => 'Rice porridge with fried shallots and ginger',      'calories' => 210, 'protein' => 6,  'carbs' => 42, 'fat' => 3,  'meal_time' => 'Breakfast', 'cuisine_type' => 'Malay',       'ingredients' => 'rice, ginger, shallots, chicken, salt'],
            ['meal_name' => 'Mee Rebus',            'description' => 'Yellow noodles in thick sweet potato gravy',        'calories' => 370, 'protein' => 14, 'carbs' => 58, 'fat' => 9,  'meal_time' => 'Breakfast', 'cuisine_type' => 'Malay',       'ingredients' => 'noodles, sweet potato, shrimp, egg, bean sprouts'],

            // --- Chinese ---
            ['meal_name' => 'Dim Sum Set',          'description' => 'Steamed dumplings with soy sauce',                  'calories' => 320, 'protein' => 14, 'carbs' => 38, 'fat' => 11, 'meal_time' => 'Breakfast', 'cuisine_type' => 'Chinese',     'ingredients' => 'shrimp, pork, flour, soy sauce, ginger'],
            ['meal_name' => 'Congee with Chicken',  'description' => 'Smooth rice porridge with shredded chicken',        'calories' => 250, 'protein' => 16, 'carbs' => 38, 'fat' => 4,  'meal_time' => 'Breakfast', 'cuisine_type' => 'Chinese',     'ingredients' => 'rice, chicken, ginger, spring onion, sesame oil'],
            ['meal_name' => 'Char Kway Teow',       'description' => 'Stir-fried flat rice noodles with egg and prawns',  'calories' => 490, 'protein' => 20, 'carbs' => 62, 'fat' => 18, 'meal_time' => 'Breakfast', 'cuisine_type' => 'Chinese',     'ingredients' => 'flat noodles, egg, prawns, bean sprouts, soy sauce, chili'],
            ['meal_name' => 'You Tiao with Soy',    'description' => 'Crispy fried dough stick with warm soy milk',       'calories' => 310, 'protein' => 9,  'carbs' => 45, 'fat' => 11, 'meal_time' => 'Breakfast', 'cuisine_type' => 'Chinese',     'ingredients' => 'flour, yeast, oil, soy milk, sugar'],

            // --- Indian ---
            ['meal_name' => 'Roti Canai',           'description' => 'Flaky flatbread served with curry dhal',            'calories' => 350, 'protein' => 8,  'carbs' => 50, 'fat' => 14, 'meal_time' => 'Breakfast', 'cuisine_type' => 'Indian',      'ingredients' => 'flour, butter, egg, curry, lentils'],
            ['meal_name' => 'Idli Sambar',          'description' => 'Steamed rice cakes with lentil soup',               'calories' => 250, 'protein' => 10, 'carbs' => 44, 'fat' => 4,  'meal_time' => 'Breakfast', 'cuisine_type' => 'Indian',      'ingredients' => 'rice flour, lentils, mustard seeds, curry leaves, tomato'],
            ['meal_name' => 'Thosai',               'description' => 'Crispy fermented rice and lentil crepe',            'calories' => 300, 'protein' => 9,  'carbs' => 50, 'fat' => 7,  'meal_time' => 'Breakfast', 'cuisine_type' => 'Indian',      'ingredients' => 'rice flour, lentils, oil, chutney, sambar'],
            ['meal_name' => 'Chapati with Dhal',    'description' => 'Whole wheat flatbread with lentil curry',           'calories' => 320, 'protein' => 12, 'carbs' => 52, 'fat' => 7,  'meal_time' => 'Breakfast', 'cuisine_type' => 'Indian',      'ingredients' => 'whole wheat flour, lentils, onion, tomato, cumin'],

            // --- Western ---
            ['meal_name' => 'Oatmeal with Fruit',   'description' => 'Healthy oats topped with banana and honey',         'calories' => 280, 'protein' => 9,  'carbs' => 52, 'fat' => 5,  'meal_time' => 'Breakfast', 'cuisine_type' => 'Western',     'ingredients' => 'oats, banana, honey, milk'],
            ['meal_name' => 'Egg Toast',             'description' => 'Whole grain toast with scrambled eggs',             'calories' => 260, 'protein' => 15, 'carbs' => 28, 'fat' => 9,  'meal_time' => 'Breakfast', 'cuisine_type' => 'Western',     'ingredients' => 'bread, egg, butter, salt'],
            ['meal_name' => 'Avocado Toast',         'description' => 'Multigrain toast topped with avocado and egg',      'calories' => 340, 'protein' => 12, 'carbs' => 32, 'fat' => 18, 'meal_time' => 'Breakfast', 'cuisine_type' => 'Western',     'ingredients' => 'bread, avocado, egg, lemon, chili flakes, salt'],
            ['meal_name' => 'Pancake Stack',         'description' => 'Fluffy pancakes with maple syrup and berries',      'calories' => 410, 'protein' => 10, 'carbs' => 68, 'fat' => 12, 'meal_time' => 'Breakfast', 'cuisine_type' => 'Western',     'ingredients' => 'flour, egg, milk, butter, maple syrup, strawberry'],

            // ═══════════════════════════════
            // LUNCH MEALS
            // ═══════════════════════════════

            // --- Malay ---
            ['meal_name' => 'Nasi Ayam',            'description' => 'Steamed chicken rice with clear soup',              'calories' => 520, 'protein' => 28, 'carbs' => 65, 'fat' => 14, 'meal_time' => 'Lunch',     'cuisine_type' => 'Malay',       'ingredients' => 'rice, chicken, ginger, garlic, soy sauce'],
            ['meal_name' => 'Laksa',                'description' => 'Spicy coconut noodle soup',                         'calories' => 550, 'protein' => 22, 'carbs' => 62, 'fat' => 22, 'meal_time' => 'Lunch',     'cuisine_type' => 'Malay',       'ingredients' => 'noodles, coconut milk, shrimp, tofu, chili, lemongrass'],
            ['meal_name' => 'Nasi Campur',          'description' => 'Mixed rice with vegetables and protein',            'calories' => 500, 'protein' => 24, 'carbs' => 60, 'fat' => 16, 'meal_time' => 'Lunch',     'cuisine_type' => 'Malay',       'ingredients' => 'rice, tempeh, vegetables, egg, sambal'],
            ['meal_name' => 'Nasi Kerabu',          'description' => 'Blue rice salad with herb vegetables and fish',     'calories' => 480, 'protein' => 22, 'carbs' => 62, 'fat' => 14, 'meal_time' => 'Lunch',     'cuisine_type' => 'Malay',       'ingredients' => 'rice, butterfly pea flower, fish, herbs, coconut, keropok'],
            ['meal_name' => 'Lontong',              'description' => 'Compressed rice with vegetable curry and tempeh',   'calories' => 460, 'protein' => 16, 'carbs' => 65, 'fat' => 15, 'meal_time' => 'Lunch',     'cuisine_type' => 'Malay',       'ingredients' => 'rice cake, tempeh, cabbage, carrot, coconut milk, chili'],

            // --- Chinese ---
            ['meal_name' => 'Wonton Noodle Soup',   'description' => 'Egg noodles in clear broth with pork wontons',      'calories' => 430, 'protein' => 24, 'carbs' => 55, 'fat' => 12, 'meal_time' => 'Lunch',     'cuisine_type' => 'Chinese',     'ingredients' => 'egg noodles, pork, shrimp, wonton skin, bok choy, soy sauce'],
            ['meal_name' => 'Fried Rice',           'description' => 'Wok-fried rice with egg, vegetables and soy sauce', 'calories' => 500, 'protein' => 18, 'carbs' => 68, 'fat' => 16, 'meal_time' => 'Lunch',     'cuisine_type' => 'Chinese',     'ingredients' => 'rice, egg, carrot, peas, soy sauce, garlic, spring onion'],
            ['meal_name' => 'Beef Noodle Soup',     'description' => 'Slow-braised beef with thick noodles in broth',     'calories' => 540, 'protein' => 32, 'carbs' => 58, 'fat' => 18, 'meal_time' => 'Lunch',     'cuisine_type' => 'Chinese',     'ingredients' => 'beef, noodles, star anise, soy sauce, bok choy, ginger'],
            ['meal_name' => 'Claypot Tofu',         'description' => 'Silken tofu braised with vegetables in claypot',    'calories' => 360, 'protein' => 20, 'carbs' => 30, 'fat' => 16, 'meal_time' => 'Lunch',     'cuisine_type' => 'Chinese',     'ingredients' => 'tofu, mushroom, carrot, soy sauce, oyster sauce, ginger'],

            // --- Indian ---
            ['meal_name' => 'Mee Goreng Mamak',     'description' => 'Spicy stir-fried yellow noodles',                   'calories' => 580, 'protein' => 18, 'carbs' => 75, 'fat' => 20, 'meal_time' => 'Lunch',     'cuisine_type' => 'Indian',      'ingredients' => 'noodles, egg, tofu, chili, tomato sauce'],
            ['meal_name' => 'Nasi Kandar',          'description' => 'White rice with various curries and sides',         'calories' => 600, 'protein' => 28, 'carbs' => 72, 'fat' => 22, 'meal_time' => 'Lunch',     'cuisine_type' => 'Indian',      'ingredients' => 'rice, chicken curry, lentil, okra, egg, curry sauce'],
            ['meal_name' => 'Biryani Rice',         'description' => 'Fragrant spiced rice with chicken or mutton',       'calories' => 580, 'protein' => 26, 'carbs' => 70, 'fat' => 18, 'meal_time' => 'Lunch',     'cuisine_type' => 'Indian',      'ingredients' => 'basmati rice, chicken, yogurt, saffron, onion, ghee, spices'],
            ['meal_name' => 'Fish Head Curry',      'description' => 'Spicy fish head cooked in tangy curry gravy',       'calories' => 420, 'protein' => 38, 'carbs' => 18, 'fat' => 22, 'meal_time' => 'Lunch',     'cuisine_type' => 'Indian',      'ingredients' => 'fish head, curry powder, coconut milk, tomato, eggplant, okra'],

            // --- Western ---
            ['meal_name' => 'Chicken Salad',        'description' => 'Grilled chicken with garden salad',                 'calories' => 380, 'protein' => 35, 'carbs' => 18, 'fat' => 16, 'meal_time' => 'Lunch',     'cuisine_type' => 'Western',     'ingredients' => 'chicken breast, lettuce, tomato, cucumber, olive oil'],
            ['meal_name' => 'Club Sandwich',        'description' => 'Triple layered sandwich with chicken and egg',      'calories' => 480, 'protein' => 28, 'carbs' => 45, 'fat' => 20, 'meal_time' => 'Lunch',     'cuisine_type' => 'Western',     'ingredients' => 'bread, chicken, egg, lettuce, tomato, mayo, bacon'],
            ['meal_name' => 'Tuna Wrap',            'description' => 'Whole wheat wrap with tuna and fresh vegetables',   'calories' => 380, 'protein' => 30, 'carbs' => 40, 'fat' => 10, 'meal_time' => 'Lunch',     'cuisine_type' => 'Western',     'ingredients' => 'tortilla wrap, tuna, lettuce, tomato, onion, mayo'],
            ['meal_name' => 'Caesar Salad',         'description' => 'Romaine lettuce with caesar dressing and croutons', 'calories' => 350, 'protein' => 22, 'carbs' => 24, 'fat' => 18, 'meal_time' => 'Lunch',     'cuisine_type' => 'Western',     'ingredients' => 'romaine lettuce, chicken, parmesan, croutons, caesar dressing'],

            // ═══════════════════════════════
            // DINNER MEALS
            // ═══════════════════════════════

            // --- Malay ---
            ['meal_name' => 'Ikan Bakar',           'description' => 'Grilled fish with sambal and ulam',                 'calories' => 380, 'protein' => 36, 'carbs' => 15, 'fat' => 16, 'meal_time' => 'Dinner',    'cuisine_type' => 'Malay',       'ingredients' => 'fish, sambal, turmeric, lemongrass, lime'],
            ['meal_name' => 'Ayam Percik',          'description' => 'Grilled chicken in spiced coconut milk marinade',   'calories' => 420, 'protein' => 38, 'carbs' => 14, 'fat' => 22, 'meal_time' => 'Dinner',    'cuisine_type' => 'Malay',       'ingredients' => 'chicken, coconut milk, lemongrass, turmeric, chili, galangal'],
            ['meal_name' => 'Rendang Daging',       'description' => 'Slow-cooked dry beef curry in coconut milk',        'calories' => 480, 'protein' => 34, 'carbs' => 12, 'fat' => 32, 'meal_time' => 'Dinner',    'cuisine_type' => 'Malay',       'ingredients' => 'beef, coconut milk, lemongrass, galangal, chili, turmeric'],
            ['meal_name' => 'Asam Pedas Ikan',      'description' => 'Sour and spicy fish stew with vegetables',          'calories' => 340, 'protein' => 32, 'carbs' => 18, 'fat' => 14, 'meal_time' => 'Dinner',    'cuisine_type' => 'Malay',       'ingredients' => 'fish, tamarind, chili, lady finger, tomato, lemongrass'],
            ['meal_name' => 'Sup Tulang',           'description' => 'Spiced bone marrow soup with bread',                'calories' => 390, 'protein' => 28, 'carbs' => 22, 'fat' => 20, 'meal_time' => 'Dinner',    'cuisine_type' => 'Malay',       'ingredients' => 'beef bone, spices, onion, tomato, potato, bread'],

            // --- Chinese ---
            ['meal_name' => 'Steamed Tofu',         'description' => 'Silken tofu with oyster sauce and greens',          'calories' => 280, 'protein' => 18, 'carbs' => 22, 'fat' => 12, 'meal_time' => 'Dinner',    'cuisine_type' => 'Chinese',     'ingredients' => 'tofu, oyster sauce, spring onion, garlic, ginger'],
            ['meal_name' => 'Sweet Sour Chicken',   'description' => 'Crispy chicken in tangy sweet and sour sauce',      'calories' => 460, 'protein' => 28, 'carbs' => 48, 'fat' => 16, 'meal_time' => 'Dinner',    'cuisine_type' => 'Chinese',     'ingredients' => 'chicken, pineapple, capsicum, tomato sauce, vinegar, sugar'],
            ['meal_name' => 'Steamed Fish',         'description' => 'Whole steamed fish with ginger and soy sauce',      'calories' => 320, 'protein' => 38, 'carbs' => 8,  'fat' => 14, 'meal_time' => 'Dinner',    'cuisine_type' => 'Chinese',     'ingredients' => 'fish, ginger, soy sauce, spring onion, sesame oil, chili'],
            ['meal_name' => 'Kung Pao Chicken',     'description' => 'Stir-fried chicken with peanuts and dried chili',   'calories' => 420, 'protein' => 30, 'carbs' => 22, 'fat' => 24, 'meal_time' => 'Dinner',    'cuisine_type' => 'Chinese',     'ingredients' => 'chicken, peanuts, dried chili, soy sauce, vinegar, garlic'],

            // --- Indian ---
            ['meal_name' => 'Chicken Curry',        'description' => 'Malaysian chicken curry with potatoes',             'calories' => 480, 'protein' => 30, 'carbs' => 38, 'fat' => 20, 'meal_time' => 'Dinner',    'cuisine_type' => 'Indian',      'ingredients' => 'chicken, potato, curry powder, coconut milk, onion'],
            ['meal_name' => 'Dhal Curry',           'description' => 'Creamy lentil curry with spices and tomatoes',      'calories' => 320, 'protein' => 16, 'carbs' => 44, 'fat' => 10, 'meal_time' => 'Dinner',    'cuisine_type' => 'Indian',      'ingredients' => 'lentils, tomato, onion, cumin, turmeric, coconut milk'],
            ['meal_name' => 'Butter Chicken',       'description' => 'Tender chicken in creamy tomato butter sauce',      'calories' => 480, 'protein' => 32, 'carbs' => 18, 'fat' => 28, 'meal_time' => 'Dinner',    'cuisine_type' => 'Indian',      'ingredients' => 'chicken, butter, tomato, cream, garam masala, garlic, ginger'],
            ['meal_name' => 'Mutton Curry',         'description' => 'Slow-cooked mutton in rich spiced curry',           'calories' => 520, 'protein' => 36, 'carbs' => 14, 'fat' => 34, 'meal_time' => 'Dinner',    'cuisine_type' => 'Indian',      'ingredients' => 'mutton, onion, tomato, yogurt, garam masala, ginger, garlic'],

            // --- Western ---
            ['meal_name' => 'Grilled Salmon',       'description' => 'Grilled salmon with steamed vegetables',            'calories' => 420, 'protein' => 38, 'carbs' => 20, 'fat' => 18, 'meal_time' => 'Dinner',    'cuisine_type' => 'Western',     'ingredients' => 'salmon, broccoli, lemon, olive oil, garlic'],
            ['meal_name' => 'Pasta Aglio Olio',     'description' => 'Spaghetti with garlic and olive oil',               'calories' => 450, 'protein' => 14, 'carbs' => 70, 'fat' => 14, 'meal_time' => 'Dinner',    'cuisine_type' => 'Western',     'ingredients' => 'pasta, garlic, olive oil, parsley, chili flakes'],
            ['meal_name' => 'Beef Steak',           'description' => 'Pan-seared beef steak with mashed potato',          'calories' => 560, 'protein' => 42, 'carbs' => 28, 'fat' => 30, 'meal_time' => 'Dinner',    'cuisine_type' => 'Western',     'ingredients' => 'beef, potato, butter, garlic, rosemary, pepper'],
            ['meal_name' => 'Baked Chicken',        'description' => 'Herb-marinated oven baked chicken with salad',      'calories' => 420, 'protein' => 40, 'carbs' => 12, 'fat' => 22, 'meal_time' => 'Dinner',    'cuisine_type' => 'Western',     'ingredients' => 'chicken, herbs, olive oil, lemon, garlic, lettuce, tomato'],

            // ═══════════════════════════════
            // SNACK MEALS
            // ═══════════════════════════════
            ['meal_name' => 'Greek Yogurt',         'description' => 'Plain yogurt with mixed berries and honey',         'calories' => 150, 'protein' => 12, 'carbs' => 18, 'fat' => 3,  'meal_time' => 'Snack',     'cuisine_type' => 'Western',     'ingredients' => 'yogurt, strawberry, blueberry, honey'],
            ['meal_name' => 'Mixed Nuts',           'description' => 'Assorted nuts and dried fruits',                    'calories' => 180, 'protein' => 5,  'carbs' => 14, 'fat' => 14, 'meal_time' => 'Snack',     'cuisine_type' => 'Western',     'ingredients' => 'almonds, cashews, raisins, walnuts'],
            ['meal_name' => 'Pisang Goreng',        'description' => 'Deep fried banana fritters',                        'calories' => 200, 'protein' => 2,  'carbs' => 32, 'fat' => 8,  'meal_time' => 'Snack',     'cuisine_type' => 'Malay',       'ingredients' => 'banana, flour, oil, sugar'],
            ['meal_name' => 'Kuih Lapis',           'description' => 'Traditional layered steamed cake',                  'calories' => 160, 'protein' => 3,  'carbs' => 30, 'fat' => 4,  'meal_time' => 'Snack',     'cuisine_type' => 'Malay',       'ingredients' => 'rice flour, coconut milk, sugar, pandan'],
            ['meal_name' => 'Onde Onde',            'description' => 'Pandan glutinous rice balls with palm sugar',       'calories' => 180, 'protein' => 2,  'carbs' => 34, 'fat' => 5,  'meal_time' => 'Snack',     'cuisine_type' => 'Malay',       'ingredients' => 'glutinous rice flour, pandan, palm sugar, coconut'],
            ['meal_name' => 'Karipap',              'description' => 'Crispy pastry filled with spiced potato and chicken','calories' => 200, 'protein' => 5,  'carbs' => 26, 'fat' => 9,  'meal_time' => 'Snack',     'cuisine_type' => 'Malay',       'ingredients' => 'flour, potato, chicken, onion, curry powder, oil'],
            ['meal_name' => 'Banana Oat Smoothie',  'description' => 'Blended banana oat smoothie with almond milk',      'calories' => 200, 'protein' => 6,  'carbs' => 38, 'fat' => 4,  'meal_time' => 'Snack',     'cuisine_type' => 'Western',     'ingredients' => 'banana, oats, almond milk, honey, cinnamon'],
            ['meal_name' => 'Boiled Egg',           'description' => 'Hard boiled eggs with black pepper',                'calories' => 140, 'protein' => 12, 'carbs' => 1,  'fat' => 10, 'meal_time' => 'Snack',     'cuisine_type' => 'Western',     'ingredients' => 'egg, salt, black pepper'],
            ['meal_name' => 'Murukku',              'description' => 'Crunchy Indian spiral snack',                       'calories' => 190, 'protein' => 4,  'carbs' => 28, 'fat' => 8,  'meal_time' => 'Snack',     'cuisine_type' => 'Indian',      'ingredients' => 'rice flour, lentil flour, cumin, chili, oil'],
            ['meal_name' => 'Spring Rolls',         'description' => 'Crispy vegetable spring rolls',                     'calories' => 200, 'protein' => 4,  'carbs' => 26, 'fat' => 10, 'meal_time' => 'Snack',     'cuisine_type' => 'Chinese',     'ingredients' => 'spring roll skin, cabbage, carrot, glass noodles, oil'],
        ];

        foreach ($meals as $meal) {
            Meal::create($meal);
        }
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const itemsList = document.querySelector('.items-list');

    const categorySynonyms = {
        electronics: [
            'electronics', 'electronic', 'gadget', 'gadgets', 'tech', 'technology', 'device', 'devices', 'appliance', 'appliances', 'hardware', 'computer', 'computers', 'laptop', 'laptops', 'tablet', 'tablets', 'phone', 'phones', 'mobile', 'mobiles', 'smartphone', 'smartphones', 'tv', 'tvs', 'television', 'televisions', 'camera', 'cameras', 'audio', 'speaker', 'speakers', 'headphone', 'headphones', 'earbud', 'earbuds', 'console', 'consoles', 'charger', 'chargers', 'monitor', 'monitors', 'screen', 'screens', 'printer', 'printers', 'router', 'routers', 'wearable', 'wearables', 'smartwatch', 'smartwatches'
        ],
        clothing: [
            'clothing', 'clothes', 'apparel', 'garment', 'garments', 'outfit', 'outfits', 'wear', 'wears', 'fashion', 'dress', 'dresses', 'shirt', 'shirts', 't-shirt', 't-shirts', 'pant', 'pants', 'jean', 'jeans', 'short', 'shorts', 'skirt', 'skirts', 'jacket', 'jackets', 'coat', 'coats', 'sweater', 'sweaters', 'hoodie', 'hoodies', 'suit', 'suits', 'blouse', 'blouses', 'sock', 'socks', 'underwear', 'lingerie', 'activewear', 'sportswear', 'uniform', 'uniforms', 'swimwear', 'swimsuit', 'swimsuits', 'footwear', 'shoe', 'shoes', 'boot', 'boots', 'sandal', 'sandals', 'sneaker', 'sneakers', 'slipper', 'slippers', 'hat', 'hats', 'cap', 'caps', 'scarf', 'scarves', 'glove', 'gloves', 'belt', 'belts'
        ],
        food: [
            'food', 'foods', 'grocery', 'groceries', 'snack', 'snacks', 'produce', 'fruit', 'fruits', 'vegetable', 'vegetables', 'meat', 'meats', 'seafood', 'fish', 'dairy', 'milk', 'cheese', 'egg', 'eggs', 'bread', 'bakery', 'cake', 'cakes', 'pastry', 'pastries', 'cereal', 'grain', 'grains', 'rice', 'pasta', 'noodle', 'noodles', 'oil', 'oils', 'spice', 'spices', 'herb', 'herbs', 'condiment', 'condiments', 'sauce', 'sauces', 'beverage', 'beverages', 'drink', 'drinks', 'juice', 'juices', 'soda', 'sodas', 'water', 'bottle', 'bottles', 'can', 'cans', 'frozen', 'frozen food', 'frozen foods', 'organic', 'snack', 'snacks', 'candy', 'candies', 'chocolate', 'chocolates', 'sweet', 'sweets'
        ],
        home: [
            'home', 'house', 'household', 'furniture', 'sofa', 'sofas', 'couch', 'couches', 'table', 'tables', 'chair', 'chairs', 'bed', 'beds', 'mattress', 'mattresses', 'lamp', 'lamps', 'light', 'lights', 'lighting', 'decor', 'decoration', 'decorations', 'carpet', 'carpets', 'rug', 'rugs', 'curtain', 'curtains', 'blind', 'blinds', 'shelf', 'shelves', 'cabinet', 'cabinets', 'drawer', 'drawers', 'closet', 'closets', 'appliance', 'appliances', 'microwave', 'microwaves', 'oven', 'ovens', 'refrigerator', 'refrigerators', 'fridge', 'fridges', 'freezer', 'freezers', 'dishwasher', 'dishwashers', 'vacuum', 'vacuums', 'cleaner', 'cleaners', 'fan', 'fans', 'heater', 'heaters', 'air conditioner', 'ac', 'humidifier', 'humidifiers', 'dehumidifier', 'dehumidifiers'
        ],
        toys: [
            'toy', 'toys', 'game', 'games', 'play', 'plaything', 'playthings', 'puzzle', 'puzzles', 'doll', 'dolls', 'action figure', 'action figures', 'lego', 'legos', 'block', 'blocks', 'car', 'cars', 'truck', 'trucks', 'train', 'trains', 'robot', 'robots', 'plush', 'plushie', 'plushies', 'stuffed animal', 'stuffed animals', 'board game', 'board games', 'card game', 'card games', 'building set', 'building sets', 'model', 'models', 'rc', 'remote control', 'remote-controlled', 'kite', 'kites', 'ball', 'balls', 'yo-yo', 'yo-yos', 'spinner', 'spinners', 'marble', 'marbles'
        ],
        books: [
            'book', 'books', 'novel', 'novels', 'literature', 'read', 'reading', 'magazine', 'magazines', 'comic', 'comics', 'manga', 'textbook', 'textbooks', 'manual', 'manuals', 'guide', 'guides', 'encyclopedia', 'encyclopedias', 'biography', 'biographies', 'autobiography', 'autobiographies', 'story', 'stories', 'fiction', 'nonfiction', 'non-fiction', 'poetry', 'poem', 'poems', 'journal', 'journals', 'publication', 'publications'
        ],
        sports: [
            'sport', 'sports', 'fitness', 'exercise', 'workout', 'gym', 'athletic', 'athletics', 'outdoor', 'outdoors', 'ball', 'balls', 'basketball', 'football', 'soccer', 'baseball', 'tennis', 'badminton', 'volleyball', 'golf', 'hockey', 'cricket', 'rugby', 'swimming', 'run', 'running', 'jog', 'jogging', 'bike', 'biking', 'bicycle', 'bicycles', 'cycling', 'skate', 'skating', 'skateboard', 'skateboards', 'ski', 'skiing', 'snowboard', 'snowboarding', 'yoga', 'mat', 'mats', 'dumbbell', 'dumbbells', 'weight', 'weights', 'trainer', 'trainers', 'coach', 'coaches'
        ],
        health: [
            'health', 'wellness', 'medicine', 'medicines', 'medication', 'medications', 'supplement', 'supplements', 'vitamin', 'vitamins', 'mineral', 'minerals', 'pill', 'pills', 'tablet', 'tablets', 'capsule', 'capsules', 'bandage', 'bandages', 'first aid', 'aid', 'remedy', 'remedies', 'pharmacy', 'pharmacies', 'mask', 'masks', 'sanitizer', 'sanitizers', 'disinfectant', 'disinfectants', 'thermometer', 'thermometers', 'monitor', 'monitors', 'blood pressure', 'bp', 'glucose', 'diabetes', 'inhaler', 'inhalers', 'ointment', 'ointments', 'cream', 'creams'
        ],
        beauty: [
            'beauty', 'cosmetic', 'cosmetics', 'makeup', 'skincare', 'skin care', 'cream', 'creams', 'lotion', 'lotions', 'serum', 'serums', 'cleanser', 'cleansers', 'toner', 'toners', 'moisturizer', 'moisturizers', 'foundation', 'foundations', 'concealer', 'concealers', 'powder', 'powders', 'blush', 'blushes', 'lipstick', 'lipsticks', 'lip gloss', 'lipgloss', 'mascara', 'mascaras', 'eyeliner', 'eyeliners', 'palette', 'palettes', 'perfume', 'perfumes', 'fragrance', 'fragrances', 'nail', 'nails', 'nail polish', 'nailpolish', 'hair', 'haircare', 'hair care', 'shampoo', 'shampoos', 'conditioner', 'conditioners'
        ],
        automotive: [
            'automotive', 'auto', 'car', 'cars', 'vehicle', 'vehicles', 'truck', 'trucks', 'motor', 'motors', 'engine', 'engines', 'tire', 'tires', 'wheel', 'wheels', 'battery', 'batteries', 'oil', 'oils', 'filter', 'filters', 'brake', 'brakes', 'headlight', 'headlights', 'taillight', 'taillights', 'mirror', 'mirrors', 'seat', 'seats', 'cover', 'covers', 'mat', 'mats', 'accessory', 'accessories', 'tool', 'tools', 'garage', 'repair', 'maintenance', 'cleaner', 'cleaners', 'wax', 'waxes', 'air freshener', 'freshener', 'fresheners'
        ],
        garden: [
            'garden', 'gardening', 'plant', 'plants', 'flower', 'flowers', 'tree', 'trees', 'shrub', 'shrubs', 'bush', 'bushes', 'lawn', 'yard', 'outdoor', 'outdoors', 'pot', 'pots', 'planter', 'planters', 'soil', 'soils', 'fertilizer', 'fertilizers', 'seed', 'seeds', 'hose', 'hoses', 'sprinkler', 'sprinklers', 'tool', 'tools', 'glove', 'gloves', 'shear', 'shears', 'pruner', 'pruners', 'rake', 'rakes', 'shovel', 'shovels', 'spade', 'spades', 'trowel', 'trowels', 'compost', 'mulch', 'greenhouse', 'greenhouses'
        ],
        pets: [
            'pet', 'pets', 'animal', 'animals', 'dog', 'dogs', 'cat', 'cats', 'puppy', 'puppies', 'kitten', 'kittens', 'fish', 'fishes', 'bird', 'birds', 'hamster', 'hamsters', 'rabbit', 'rabbits', 'guinea pig', 'guinea pigs', 'reptile', 'reptiles', 'petcare', 'pet care', 'pet food', 'petfood', 'treat', 'treats', 'toy', 'toys', 'leash', 'leashes', 'collar', 'collars', 'bowl', 'bowls', 'cage', 'cages', 'aquarium', 'aquariums', 'litter', 'litterbox', 'litter box', 'scratching post', 'kennel', 'kennels', 'crate', 'crates', 'bed', 'beds'
        ],
        office: [
            'office', 'stationery', 'stationary', 'desk', 'desks', 'chair', 'chairs', 'table', 'tables', 'pen', 'pens', 'pencil', 'pencils', 'notebook', 'notebooks', 'paper', 'papers', 'folder', 'folders', 'binder', 'binders', 'file', 'files', 'organizer', 'organizers', 'calendar', 'calendars', 'planner', 'planners', 'envelope', 'envelopes', 'clip', 'clips', 'stapler', 'staplers', 'highlighter', 'highlighters', 'marker', 'markers', 'eraser', 'erasers', 'tape', 'tapes', 'printer', 'printers', 'scanner', 'scanners', 'shredder', 'shredders', 'lamp', 'lamps', 'supply', 'supplies'
        ],
        music: [
            'music', 'musical', 'instrument', 'instruments', 'audio', 'sound', 'song', 'songs', 'album', 'albums', 'band', 'bands', 'guitar', 'guitars', 'piano', 'pianos', 'keyboard', 'keyboards', 'drum', 'drums', 'violin', 'violins', 'flute', 'flutes', 'saxophone', 'saxophones', 'trumpet', 'trumpets', 'clarinet', 'clarinets', 'microphone', 'microphones', 'speaker', 'speakers', 'headphone', 'headphones', 'earbud', 'earbuds', 'amp', 'amps', 'amplifier', 'amplifiers', 'record', 'records', 'vinyl', 'vinyls', 'cd', 'cds', 'mp3', 'mp3s', 'playlist', 'playlists', 'composer', 'composers', 'sheet', 'sheet music'
        ]
    };

    searchInput.addEventListener('input', function() {
        // Reset all filters to "all"
        document.getElementById('Distance').value = 'all';
        document.getElementById('Category').value = 'all';
        document.getElementById('Price').value = 'all';

        const value = this.value.trim().toLowerCase();
        const searchWords = value.split(/\s+/);
        const items = document.querySelectorAll('.item');

        items.forEach(item => {
            const title = item.querySelector('.item-title').textContent.toLowerCase();
            const meta = item.querySelector('.item-meta').textContent.toLowerCase();
            const category = item.dataset.category || '';

            const matches = searchWords.every(word => {
                if (title.includes(word) || meta.includes(word)) return true;
                if (
                    categorySynonyms[category] &&
                    categorySynonyms[category].some(syn => syn.includes(word))
                ) return true;
                return false;
            });

            item.style.display = matches ? '' : 'none';
        });
    });
});
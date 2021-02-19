from haversine import haversine, Unit

# A shopper covers x percentage of all the shops, lives less than 10km from shop
# Shopper lives within 10 kilometers of 2 out of 4 shops > 100 * 2 / 4 (4 being total length of array) 

locations = [
    {'id': 1000, 'zip_code': '37069', 'lat': 45.35, 'lng': 10.84},
    {'id': 1001, 'zip_code': '37121', 'lat': 45.44, 'lng': 10.99},
    {'id': 1002, 'zip_code': '37129', 'lat': 45.44, 'lng': 11.00},
    {'id': 1003, 'zip_code': '37133', 'lat': 45.43, 'lng': 11.02}
]

shoppers = [
    {'id': 'S1', 'lat': 45.46, 'lng': 11.03, 'enabled': 1},
    {'id': 'S2', 'lat': 45.46, 'lng': 10.12, 'enabled': 1},
    {'id': 'S3', 'lat': 45.34, 'lng': 10.81, 'enabled': 1},
    {'id': 'S4', 'lat': 45.76, 'lng': 10.57, 'enabled': 1},
    {'id': 'S5', 'lat': 45.34, 'lng': 10.63, 'enabled': 1},
    {'id': 'S6', 'lat': 45.42, 'lng': 10.81, 'enabled': 1},
    {'id': 'S7', 'lat': 45.34, 'lng': 10.94, 'enabled': 1}
]

shops = len(locations)

coverages = []

# Loop through all shoppers and determine for each shop if it is accessible to him/her
for shopper in shoppers:
    if shopper['enabled'] == 1:
        for location in locations:
            # Determine distance to the shop
            distance = haversine((shopper['lat'], shopper['lng']), (location['lat'], location['lng']))
            
            if distance < 10:
                # At lease 1 shop is accessible
                visitable = 1
                
                # Sheck if shops were already marked as accessible and if so 'update' its entry
                for index in range(len(coverages)):
                    # If another shop is also accessible remove that element and add to the number of shops
                    if shopper['id'] in coverages[index].values():
                        visitable = coverages[index]['visitable'] +1

                        del coverages[index]

                coverages.append({'shopper_id': shopper['id'], 'visitable': visitable, 'coverage': 100 * visitable / shops})

# Sort resulting array DESC
coverages = sorted(coverages, key=lambda x:x['coverage'])[::-1]

print(coverages)
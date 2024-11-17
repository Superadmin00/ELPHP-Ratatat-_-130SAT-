## USER REGISTRATION

Request Type: POST<br>
URL: http://127.0.0.1:8000/api/register<br>
Authorization: NONE<br>
Header:

    |----------KEY----------|---------VALUE---------|
    |-Content-Type----------|-application/json------|

Body: form-data

    |----------KEY----------|---------VALUE---------|
    |-email-----------------|-johndoe@gmail.com-----|
    |-password--------------|-123123----------------|
    |-password_confirmation-|-123123----------------|
    |-user_first_name-------|-John------------------|
    |-user_last_name--------|-Doe-------------------|

Returns:

    Response Code: 200
    Body:
    {
        "user": {
            "email": "johndoe@gmail.com",
            "user_first_name": "John",
            "user_last_name": "Doe",
            "updated_at": "2024-11-14T08:51:52.000000Z",
            "created_at": "2024-11-14T08:51:52.000000Z",
            "id": 1
        },
        "token": "1|8WgoyY4P2fCTv1bP2pOMa50QYV3Sj8HwBDaNdj6j605efb58"
    }

## USER LOGIN

Request Type: POST<br>
URL: http://127.0.0.1:8000/api/login<br>
Authorization: NONE<br>
Header:

    |----------KEY----------|---------VALUE---------|
    |-Content-Type----------|-application/json------|

Body: form-data

    |----------KEY----------|---------VALUE---------|
    |-email-----------------|-johndoe@gmail.com-----|
    |-password--------------|-123123----------------|

Returns:

    Response Code: 200
    Body:
    {
        "user": {
            "id": 1,
            "email": "johndoe@gmail.com",
            "email_verified_at": null,
            "user_first_name": "John",
            "user_mid_name": null,
            "user_last_name": "Doe",
            "user_profile_pic_ref": null,
            "user_status": "active",
            "created_at": "2024-11-14T08:51:52.000000Z",
            "updated_at": "2024-11-14T08:51:52.000000Z"
        },
        "token": "2|5pGdpFziVx2wCHomUMeutBio6fUxhEbBbuxsbMdd86b4aaf4"
    }

## USER LOGOUT

Request Type: POST<br>
URL: http://127.0.0.1:8000/api/logout<br>
Authorization: Bearer Token (from login response or register response)<br>
Header:

    |----------KEY----------|---------VALUE---------|
    |-Content-Type----------|-application/json------|

Body: NONE<br>

Returns:

    Response Code: 200
    Body:
    {
        "message": "Logged out successfully."
    }

## USER FORGOT PASSWORD

Request Type: POST<br>
URL: http://127.0.0.1:8000/api/user/forgot-password<br>
Authorization: NONE<br>
Header:

    |----------KEY----------|---------VALUE---------|
    |-Content-Type----------|-application/json------|

Body: form-data

    |-------------KEY-------------|---------VALUE---------|
    |-email-----------------------|-johndoe@gmail.com-----|
    |-new_password----------------|-456456----------------|
    |-new_password_confirmation---|-456456----------------|

Returns:

    Response Code: 200

    Body:
    {
        "message": "Password reset successfully. Please log in with your new password."
    }

## USER SHOW PROFILE

Request Type: GET<br>
URL: http://127.0.0.1:8000/api/user<br>
Authorization: Bearer Token (from login response or register response)<br>
Header:

    |----------KEY----------|---------VALUE---------|
    |-Content-Type----------|-application/json------|

Body: NONE<br>

Returns:

    Response Code: 200
    Body:
    {
        "id": 1,
        "email": "johndoe@gmail.com",
        "email_verified_at": null,
        "user_first_name": "John",
        "user_mid_name": null,
        "user_last_name": "Doe",
        "user_profile_pic_ref": null,
        "user_status": "active",
        "created_at": "2024-11-14T12:07:28.000000Z",
        "updated_at": "2024-11-14T12:07:28.000000Z"
    }

## USER EDIT PROFILE

Request Type: POST<br>
URL: http://127.0.0.1:8000/api/user/edit<br>
Authorization: Bearer Token (from login response or register response)<br>
Header:

    |----------KEY----------|---------VALUE---------|
    |-Content-Type----------|-application/json------|

Body: form-data

    |----------KEY----------|---------VALUE---------|
    |-_method---------------|-PATCH-----------------|
    |-user_first_name-------|-John------------------|
    |-user_last_name--------|-Doe-------------------|
    |-user_profile_pic_ref--|-(optional, image file, only jpg/jpeg/jfif/png/webp)|

Returns:

    Response Code: 200
    Body:
    {
        "message": "Profile updated successfully.",
        "user": {
            "id": 1,
            "email": "johndoe@gmail.com",
            "email_verified_at": null,
            "user_first_name": "Borge",
            "user_mid_name": "Batumbakal",
            "user_last_name": "Petsky",
            "user_profile_pic_ref": "storage/profile_pics/jM9x25QCwaj5hxzcSLskC4ThVG7iK5gij6NWgJzD.jpg",
            "user_status": "active",
            "created_at": "2024-11-14T12:07:28.000000Z",
            "updated_at": "2024-11-14T20:01:00.000000Z"
        }
    }

## RECIPE SHOW ALL

Request Type: GET
URL: http://127.0.0.1:8000/api/recipes<br>
Authorization: NONE<br>
Header:

    |----------KEY----------|---------VALUE---------|
    |-Content-Type----------|-application/json------|

Body: NONE<br>

Returns:

    Response Code: 200
    Body:
    [
        {
            "id": 12,
            "user_id": 1,
            "recipe_category": "Main Course updated",
            "recipe_title": "Creamy Tomato Soup",
            "recipe_description": "A comforting and flavorful soup perfect for a chilly day.",
            "recipe_ingredients": [
                "2 tablespoons olive oil",
                "1 onion, chopped",
                "3 cloves garlic, minced"
            ],
            "recipe_instructions": [
                "Heat olive oil in a large pot.",
                "Add onion and garlic, cook until softened."
            ],
            "recipe_img_refs": [
                "/storage/recipe-images/UJM2KnNCSub88eU2KyHEI2BxnWSS4055c2E2vEGe.jpg",
                "/storage/recipe-images/DS2AJdnMaLqXKo5LuE6ckfccYUnKYYVMgkfkrdFO.jpg"
            ],
            "recipe_prep_time": 15,
            "recipe_cook_time": 30,
            "recipe_servings": 4,
            "recipe_status": "inactive",
            "created_at": "2024-11-14T18:50:17.000000Z",
            "updated_at": "2024-11-14T18:51:10.000000Z"
        },
        ...
    ]

## RECIPE SHOW SINGLE

Request Type: GET
URL: http://127.0.0.1:8000/api/recipes/{id}<br>
Authorization: NONE<br>
Header:

    |----------KEY----------|---------VALUE---------|
    |-Content-Type----------|-application/json------|

Body: NONE<br>

Returns:

    Response Code: 200
    Body:
    {
        "id": 12,
        "user_id": 1,
        "recipe_category": "Main Course updated",
        "recipe_title": "Creamy Tomato Soup",
        "recipe_description": "A comforting and flavorful soup perfect for a chilly day.",
        "recipe_ingredients": [
            "2 tablespoons olive oil",
            "1 onion, chopped",
            "3 cloves garlic, minced"
        ],
        "recipe_instructions": [
            "Heat olive oil in a large pot.",
            "Add onion and garlic, cook until softened."
        ],
        "recipe_img_refs": [
            "/storage/recipe-images/UJM2KnNCSub88eU2KyHEI2BxnWSS4055c2E2vEGe.jpg",
            "/storage/recipe-images/DS2AJdnMaLqXKo5LuE6ckfccYUnKYYVMgkfkrdFO.jpg"
        ],
        "recipe_prep_time": 15,
        "recipe_cook_time": 30,
        "recipe_servings": 4,
        "recipe_status": "inactive",
        "created_at": "2024-11-14T18:50:17.000000Z",
        "updated_at": "2024-11-14T18:51:10.000000Z"
    }

## RECIPE STORE

Request Type: POST<br>
URL: http://127.0.0.1:8000/api/recipes<br>
Authorization: Bearer Token (from login response or register response)<br>
Header:

    |----------KEY----------|---------VALUE---------|
    |-Content-Type----------|-application/json------|

Body: form-data

    |----------KEY----------|---------VALUE---------|
    |-recipe_category-------|-Main Course-----------|
    |-recipe_title----------|-Creamy Tomato Soup----|

    |-recipe_description----|-A comforting and flavorful soup perfect for a chilly day.---|
    |-recipe_ingredients----|-["2 tablespoons olive oil", "1 onion, chopped", "3 cloves garlic, minced", "28 ounce can crushed tomatoes", "14.5 ounce can vegetable broth", "1 cup heavy cream", "1 teaspoon dried oregano", "1/2 teaspoon dried basil", "Salt and pepper to taste"]---|

    |-recipe_instructions---|-["Heat olive oil in a large pot over medium heat.", "Add onion and garlic, cook until softened.", "Stir in crushed tomatoes, vegetable broth, oregano, and basil. Bring to a boil, then reduce heat and simmer for 30 minutes.", "Stir in heavy cream and season with salt and pepper to taste.", "Serve hot with crusty bread."]---|

    |-images[]--------------|-(required, first image file upload, only jpg/jpeg/jfif/png/webp)---|
    |-images[]--------------|-(optional, more image file uploads, only jpg/jpeg/jfif/png/webp)---|
    |-recipe_prep_time------|-15-------------------|
    |-recipe_cook_time------|-30-------------------|
    |-recipe_servings-------|-4--------------------|
    |-recipe_status---------|-active---------------|

Returns:

    Response Code: 200
    Body:
    {
        "recipe_category": "Main Course",
        "recipe_title": "Creamy Tomato Soup",
        "recipe_description": "A comforting and flavorful soup perfect for a chilly day.",
        "recipe_ingredients": [
            "2 tablespoons olive oil",
            "1 onion, chopped",
            "3 cloves garlic, minced",
            "28 ounce can crushed tomatoes",
            "14.5 ounce can vegetable broth",
            "1 cup heavy cream",
            "1 teaspoon dried oregano",
            "1/2 teaspoon dried basil",
            "Salt and pepper to taste"
        ],
        "recipe_instructions": [
            "Heat olive oil in a large pot over medium heat.",
            "Add onion and garlic, cook until softened.",
            "Stir in crushed tomatoes, vegetable broth, oregano, and basil. Bring to a boil, then reduce heat and simmer for 30 minutes.",
            "Stir in heavy cream and season with salt and pepper to taste.",
            "Serve hot with crusty bread."
        ],
        "recipe_img_refs": [
            "/storage/recipe-images/gVGO8ZlSCrBikRwtCzKvjlvcvb9ZM6ME2seEtnce.jpg"
        ],
        "recipe_prep_time": "15",
        "recipe_cook_time": "30",
        "recipe_servings": "4",
        "recipe_status": "active",
        "user_id": 1,
        "updated_at": "2024-11-14T18:50:17.000000Z",
        "created_at": "2024-11-14T18:50:17.000000Z",
        "id": 12
    }

## RECIPE UPDATE

Request Type: POST<br>
URL: http://127.0.0.1:8000/api/recipes/{id}<br>
Authorization: Bearer Token (from login response or register response)<br>
Header:

    |----------KEY----------|---------VALUE---------|
    |-Content-Type----------|-application/json------|

Body: form-data

    |----------KEY----------|---------VALUE---------|
    |-_method---------------|-PUT-------------------|
    |-recipe_category-------|-Main Course-----------|
    |-recipe_title----------|-Creamy Tomato Soup----|
    |-recipe_description----|-A comforting and flavorful soup perfect for a chilly day.---|

    |-recipe_ingredients----|-["2 tablespoons olive oil", "1 onion, chopped", "3 cloves garlic, minced", "28 ounce can crushed tomatoes", "14.5 ounce can vegetable broth", "1 cup heavy cream", "1 teaspoon dried oregano", "1/2 teaspoon dried basil", "Salt and pepper to taste"]---|

    |-recipe_instructions---|-["Heat olive oil in a large pot over medium heat.", "Add onion and garlic, cook until softened.", "Stir in crushed tomatoes, vegetable broth, oregano, and basil. Bring to a boil, then reduce heat and simmer for 30 minutes.", "Stir in heavy cream and season with salt and pepper to taste.", "Serve hot with crusty bread."]---|

    |-images[]--------------|-(first image file, only jpg/jpeg/jfif/png/webp)---|
    |-images[]--------------|-(optional, second image file, only jpg/jpeg/jfif/png/webp)---|
    |-recipe_prep_time------|-15-------------------|
    |-recipe_cook_time------|-30-------------------|
    |-recipe_servings-------|-4--------------------|
    |-recipe_status---------|-active---------------|

Returns:

    Response Code: 200
    Body:
    {
        "id": 12,
        "user_id": 1,
        "recipe_category": "Main Course updated",
        "recipe_title": "Creamy Tomato Soup",
        "recipe_description": "A comforting and flavorful soup perfect for a chilly day.",
        "recipe_ingredients": [
            "2 tablespoons olive oil",
            "1 onion, chopped",
            "3 cloves garlic, minced"
        ],
        "recipe_instructions": [
            "Heat olive oil in a large pot.",
            "Add onion and garlic, cook until softened."
        ],
        "recipe_img_refs": [
            "/storage/recipe-images/UJM2KnNCSub88eU2KyHEI2BxnWSS4055c2E2vEGe.jpg",
            "/storage/recipe-images/DS2AJdnMaLqXKo5LuE6ckfccYUnKYYVMgkfkrdFO.jpg"
        ],
        "recipe_prep_time": "15",
        "recipe_cook_time": "30",
        "recipe_servings": "4",
        "recipe_status": "inactive",
        "created_at": "2024-11-14T18:50:17.000000Z",
        "updated_at": "2024-11-14T18:51:10.000000Z"
    }

## RECIPE DELETE

Request Type: DELETE<br>
URL: http://127.0.0.1:8000/api/recipes/{id}<br>
Authorization: Bearer Token (from login response or register response)<br>
Header:

    |----------KEY----------|---------VALUE---------|
    |-Content-Type----------|-application/json------|

Body: NONE<br>

Returns:

    Response Code: 200
    Body:
    {
        "message": "Recipe deleted successfully"
    }

## RECIPE LIKE or UNLIKE

Request Type: POST<br>
URL: http://127.0.0.1:8000/api/recipes/{id}/like<br>
Authorization: Bearer Token (from login response or register response)<br>
Header:

    |----------KEY----------|---------VALUE---------|
    |-Content-Type----------|-application/json------|

Body: NONE<br>

Returns:

    If user liked the recipe:
        Response Code: 200
        Body:
        {
            "message": "LIKED"
        }

    If user unliked the recipe:
        Response Code: 200
        Body:
        {
            "message": "UNLIKED"
        }

## RECIPE GET LIKES COUNT and IF LIKED BY USER

Request Type: GET<br>
URL: http://127.0.0.1:8000/api/recipes/{id}/likes-count<br>
Authorization: Bearer Token (from login response or register response)<br>
Header:

    |----------KEY----------|---------VALUE---------|
    |-Content-Type----------|-application/json------|

Body: NONE<br>

Returns:

    Response Code: 200

    if user liked the recipe:
        Body:
        {
            "likes_count": 1,
            "user_liked": true
        }

    if user unliked the recipe:
        Body:
        {
            "likes_count": 0,
            "user_liked": false
        }

## RECIPE FAVORITE or UNFAVORITE

Request Type: POST<br>
URL: http://127.0.0.1:8000/api/recipes/{id}/favorite<br>
Authorization: Bearer Token (from login response or register response)<br>
Header:

    |----------KEY----------|---------VALUE---------|
    |-Content-Type----------|-application/json------|

Body: NONE<br>

Returns:

    Response Code: 200

    If user favorited the recipe:
        Body:
        {
            "message": "Favorited"
        }

    If user unfavorited the recipe:
        Body:
        {
            "message": "UNFAVORITED"
        }

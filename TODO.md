# TODO: Fix Namespace Issue for Models

## Steps to Complete

1. **Update namespace in model files to `App\Http\Models`:**
   - [ ] Update namespace in `app/Http/Models/Favorite.php`
   - [ ] Update namespace in `app/Http/Models/Genre.php`
   - [ ] Update namespace in `app/Http/Models/Mood.php`
   - [ ] Update namespace in `app/Http/Models/Movie.php`
   - [ ] Update namespace in `app/Http/Models/Review.php`
   - [ ] Update namespace in `app/Http/Models/User.php`

2. **Update use statements in PHP files:**
   - [ ] Search and update `use App\Models\` to `use App\Http\Models\` in all relevant files (controllers, etc.)

3. **Refresh autoloader:**
   - [ ] Run `composer dump-autoload` to refresh the autoloading

4. **Test the application:**
   - [ ] Start the Laravel server and verify the home page loads without errors

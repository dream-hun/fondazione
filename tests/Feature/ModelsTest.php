<?php

declare(strict_types=1);

use App\Http\Controllers\ContactController;
use App\Models\Blog;
use App\Models\Department;
use App\Models\Notice;
use App\Models\Project;
use App\Models\Report;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('blog can be published', function (): void {
    $blog = Blog::factory()->draft()->create();

    expect($blog->publish())->toBeTrue()
        ->and($blog->refresh()->status)->toBe('published')
        ->and($blog->published_at)->not->toBeNull();
});

test('blog can be marked and unmarked as featured', function (): void {
    $blog = Blog::factory()->create(['is_featured' => false]);

    $blog->makeFeatured();
    expect($blog->refresh()->is_featured)->toBeTrue();

    $blog->removeFeatured();
    expect($blog->refresh()->is_featured)->toBeFalse();
});

test('blog draft and featured scopes filter correctly', function (): void {
    $draft = Blog::factory()->draft()->create(['title' => 'Draft One']);
    Blog::factory()->published()->create(['title' => 'Live One']);
    $featured = Blog::factory()->published()->featured()->create(['title' => 'Star One']);

    expect(Blog::query()->draft()->pluck('id'))->toContain($draft->id)->toHaveCount(1)
        ->and(Blog::query()->featured()->pluck('id'))->toContain($featured->id);
});

test('blog by tag scope matches comma separated tags', function (): void {
    $tagged = Blog::factory()->create(['tags' => 'agriculture, water, youth']);
    Blog::factory()->create(['tags' => 'finance, budget']);

    expect(Blog::query()->byTag('water')->pluck('id')->all())->toBe([$tagged->id]);
});

test('blog status label reflects the stored status', function (): void {
    $draft = Blog::factory()->draft()->create();
    $published = Blog::factory()->published()->create();

    expect($draft->status_label)->toBe('Draft')
        ->and($published->status_label)->toBe('Published');
});

test('blog is active only for published posts dated in the past', function (): void {
    $live = Blog::factory()->published()->create(['published_at' => now()->subDay()]);
    $scheduled = Blog::factory()->published()->create(['published_at' => now()->addDay()]);
    $undated = Blog::factory()->published()->create(['published_at' => null]);
    $draft = Blog::factory()->draft()->create(['published_at' => now()->subDay()]);

    expect($live->is_active)->toBeTrue()
        ->and($scheduled->is_active)->toBeFalse()
        ->and($undated->is_active)->toBeFalse()
        ->and($draft->is_active)->toBeFalse();
});

test('blog featured image url handles missing, remote and local paths', function (): void {
    $none = Blog::factory()->create(['featured_image' => null]);
    $remote = Blog::factory()->create(['featured_image' => 'https://example.com/img.jpg']);
    $local = Blog::factory()->create(['featured_image' => 'blogs/local.jpg']);

    expect($none->featured_image_url)->toBeNull()
        ->and($remote->featured_image_url)->toBe('https://example.com/img.jpg')
        ->and($local->featured_image_url)->toBe(asset('storage/blogs/local.jpg'));
});

test('blog tags array splits and trims the raw string', function (): void {
    $blog = Blog::factory()->create(['tags' => ' alpha , beta ,gamma ']);

    expect($blog->tags_array)->toBe(['alpha', 'beta', 'gamma'])
        ->and(Blog::factory()->create(['tags' => null])->tags_array)->toBe([]);
});

test('blog reading time prefers the stored value and falls back to content length', function (): void {
    $stored = Blog::factory()->create(['reading_time' => 7, 'content' => 'tiny']);
    $computed = Blog::factory()->create(['reading_time' => null, 'content' => str_repeat('word ', 450)]);

    expect($stored->reading_time)->toBe(7)
        ->and($computed->reading_time)->toBe(3);
});

test('notice generates a uuid automatically', function (): void {
    $notice = Notice::factory()->create();

    expect($notice->uuid)->not->toBeNull()
        ->and(Illuminate\Support\Str::isUuid((string) $notice->uuid))->toBeTrue();
});

test('notice knows whether it has an attachment', function (): void {
    $withFile = Notice::factory()->create(['attachment' => 'notices/file.pdf']);
    $withoutFile = Notice::factory()->create(['attachment' => null]);

    expect($withFile->hasAttachment())->toBeTrue()
        ->and($withoutFile->hasAttachment())->toBeFalse();
});

test('notice formatted date renders created at', function (): void {
    $notice = Notice::factory()->create(['created_at' => '2026-03-05 10:00:00']);

    expect($notice->formatted_date)->toBe('Mar 5, 2026');
});

test('team generates a uuid automatically', function (): void {
    $team = Team::factory()->create();

    expect(Illuminate\Support\Str::isUuid((string) $team->uuid))->toBeTrue();
});

test('team image url handles missing, remote and local images', function (): void {
    $none = Team::factory()->create(['image' => null]);
    $remote = Team::factory()->create(['image' => 'https://example.com/avatar.png']);
    $local = Team::factory()->create(['image' => 'teams/local.png']);

    expect($none->image_url)->toBeNull()
        ->and($remote->image_url)->toBe('https://example.com/avatar.png')
        ->and($local->image_url)->toBe(asset('storage/teams/local.png'));
});

test('project can be published and archived', function (): void {
    $project = Project::factory()->draft()->create();

    expect($project->publish())->toBeTrue()
        ->and($project->refresh()->status)->toBe('published')
        ->and($project->archive())->toBeTrue()
        ->and($project->refresh()->status)->toBe('archived');
});

test('project featured toggles work', function (): void {
    $project = Project::factory()->create(['is_featured' => false]);

    $project->makeFeatured();
    expect($project->refresh()->is_featured)->toBeTrue();

    $project->removeFeatured();
    expect($project->refresh()->is_featured)->toBeFalse();
});

test('project archived and category scopes filter correctly', function (): void {
    $archived = Project::factory()->archived()->create(['category' => 'wdp']);
    $cdsp = Project::factory()->cdsp()->published()->create();
    Project::factory()->wdp()->published()->create();

    expect(Project::query()->archived()->pluck('id')->all())->toBe([$archived->id])
        ->and(Project::query()->category(App\Enum\Projects\Category::Cdsp)->pluck('id')->all())->toBe([$cdsp->id]);
});

test('project status label reflects the stored status', function (): void {
    $draft = Project::factory()->draft()->create();
    $published = Project::factory()->published()->create();
    $archived = Project::factory()->archived()->create();

    expect($draft->status_label)->toBe('Draft')
        ->and($published->status_label)->toBe('Published')
        ->and($archived->status_label)->toBe('Archived')
        ->and($draft->is_active)->toBeFalse()
        ->and($published->is_active)->toBeTrue()
        ->and($archived->is_active)->toBeFalse();
});

test('project gallery image urls normalizes raw values', function (): void {
    $project = Project::factory()->create([
        'gallery_images' => ['projects/a.jpg', '', 'https://cdn.example.com/b.jpg'],
    ]);

    $urls = $project->gallery_image_urls;

    expect($urls)->toHaveCount(2)
        ->and($urls[0])->toBe(asset('storage/projects/a.jpg'))
        ->and($urls[1])->toBe('https://cdn.example.com/b.jpg');

    expect(Project::factory()->create(['gallery_images' => null])->gallery_image_urls)->toBe([]);
});

test('report scopes filter by notice style statuses', function (): void {
    $published = Report::factory()->published()->create();
    $unpublished = Report::factory()->unpublished()->create();
    $draft = Report::factory()->draft()->create(['title' => 'Draft Annual Report']);
    Report::factory()->create(['title' => 'Other Document']);

    expect(Report::query()->published()->pluck('id')->all())->toBe([$published->id])
        ->and(Report::query()->unpublished()->pluck('id')->all())->toBe([$unpublished->id])
        ->and(Report::query()->draft()->pluck('id')->all())->toContain($draft->id)
        ->and(Report::query()->search('Annual')->pluck('id')->all())->toBe([$draft->id]);
});

test('user reports admin status and updates last login', function (): void {
    $admin = User::factory()->create(['is_admin' => true]);
    $member = User::factory()->create(['is_admin' => false]);

    expect($admin->isAdmin())->toBeTrue()
        ->and($member->isAdmin())->toBeFalse();

    $member->updateLastLogin();

    expect($member->fresh()->last_login_at)->not->toBeNull();
});

test('user password remains hashed through the cast', function (): void {
    $user = User::factory()->create(['password' => 'plain-secret']);

    expect(Hash::check('plain-secret', $user->password))->toBeTrue();
});

test('department slugs are generated from the name', function (): void {
    $department = Department::factory()->create(['name' => 'Community Outreach']);

    expect($department->slug)->toBe('community-outreach');
});

test('department names that collide receive unique suffixed slugs', function (): void {
    $first = Department::factory()->create(['name' => 'Duplicate Squad']);
    $second = Department::factory()->create(['name' => 'Duplicate Squad']);

    expect($first->slug)->toBe('duplicate-squad')
        ->and($second->slug)->toBe('duplicate-squad-1');
});

test('department scopes filter and order correctly', function (): void {
    $inactive = Department::factory()->inactive()->create(['display_order' => 1, 'name' => 'B Unit']);
    $active = Department::factory()->create(['display_order' => 0, 'name' => 'A Unit']);
    $searched = Department::factory()->inactive()->create([
        'display_order' => 2,
        'head_of_department' => 'Dr. Water Expert',
        'name' => 'C Unit',
    ]);

    expect(Department::query()->active()->pluck('id')->all())->toBe([$active->id])
        ->and(Department::query()->inactive()->pluck('id')->all())->toBe([$inactive->id, $searched->id])
        ->and(Department::query()->ordered()->pluck('name')->all())->toBe(['A Unit', 'B Unit', 'C Unit'])
        ->and(Department::query()->search('Water Expert')->pluck('id')->all())->toBe([$searched->id]);
});

test('department casts responsibilities and exposes its status label', function (): void {
    $active = Department::factory()->create([
        'key_responsibilities' => ['Train farmers', 'Dig wells'],
        'is_active' => true,
    ]);
    $inactive = Department::factory()->inactive()->create();

    expect($active->key_responsibilities)->toBe(['Train farmers', 'Dig wells'])
        ->and($active->status_label)->toBe('Active')
        ->and($inactive->status_label)->toBe('Inactive');
});

test('slug stays untouched when only the title changes', function (): void {
    $blog = Blog::factory()->create(['title' => 'Original Heading', 'slug' => 'original-heading']);

    $blog->update(['title' => 'Rewritten Heading']);

    expect($blog->fresh()->slug)->toBe('original-heading');
});

test('slug regenerates when cleared during an update without colliding with itself', function (): void {
    $blog = Blog::factory()->create(['title' => 'Original Heading', 'slug' => 'original-heading']);

    $blog->update(['title' => 'Fresh Heading', 'slug' => null]);

    expect($blog->fresh()->slug)->toBe('fresh-heading');
});

test('slug falls back to the table name when the source column is empty', function (): void {
    $department = Department::factory()->create(['name' => '']);

    expect($department->slug)->toStartWith('departments-');

    $department->delete();
});

test('contact controller is invokable even though it has no route yet', function (): void {
    $controller = new ContactController;

    $controller->__invoke(new Request);

    expect($controller)->toBeInstanceOf(ContactController::class);
});

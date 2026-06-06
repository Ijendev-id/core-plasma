<?php

namespace Tests\Feature;

use App\Models\LearningPackage;
use App\Models\Member;
use App\Models\TryoutQuestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page()
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('member.login'));
    }

    public function test_members_can_login_from_members_table()
    {
        $member = Member::factory()->create([
            'email' => 'member@example.test',
            'password' => 'password',
        ]);

        $response = $this->post(route('member.login.store'), [
            'email' => 'member@example.test',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($member, 'member');
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_authenticated_users_can_visit_the_dashboard()
    {
        $member = Member::factory()->create([
            'name' => 'Asisi Alfaiz',
        ]);
        LearningPackage::factory()->create([
            'name' => 'CPNS 2024 Ultimate Prep',
            'slug' => 'cpns-2024-ultimate-prep',
            'status' => 'published',
        ]);

        $this->actingAs($member, 'member');

        $response = $this->get(route('dashboard'));
        $response
            ->assertOk()
            ->assertSee('Selamat Belajar')
            ->assertSee('Asisi Alfaiz');
    }

    public function test_authenticated_users_can_visit_tryout_pages()
    {
        $member = Member::factory()->create();
        $package = LearningPackage::factory()->create([
            'name' => 'CPNS 2024 Ultimate Prep',
            'slug' => 'cpns-2024-ultimate-prep',
            'status' => 'published',
        ]);
        $question = $package->questions()->create([
            'section' => 'TIU',
            'prompt' => 'Pertanyaan tryout dari database untuk halaman simulasi.',
            'order_number' => 1,
            'points' => 5,
            'is_active' => true,
        ]);
        foreach (['A', 'B', 'C', 'D', 'E'] as $label) {
            $question->answers()->create([
                'label' => $label,
                'answer_text' => "Jawaban {$label}",
                'is_correct' => $label === 'C',
            ]);
        }

        $this->actingAs($member, 'member');

        $this->get(route('tryouts.index'))
            ->assertOk()
            ->assertSee('Try Out Saya')
            ->assertSee('CPNS 2024 Ultimate Prep');

        $this->get(route('tryouts.play', $package))
            ->assertOk()
            ->assertSee('Soal 1 dari 1')
            ->assertSee('Pertanyaan tryout dari database');

        $this->get(route('leaderboard'))
            ->assertOk()
            ->assertSee('Puncak Pretul');
    }

    public function test_authenticated_users_can_visit_admin_package_inventory()
    {
        $user = User::factory()->create();
        LearningPackage::factory()->create([
            'name' => 'CPNS 2024 Ultimate Prep',
            'slug' => 'cpns-2024-ultimate-prep',
        ]);

        $this->actingAs($user);

        $response = $this->get(route('admin.packages.index'));
        $response
            ->assertOk()
            ->assertSee('Package Inventory')
            ->assertSee('CPNS 2024 Ultimate Prep');
    }

    public function test_admin_user_management_reads_from_members_table()
    {
        $admin = User::factory()->create();
        Member::factory()->create([
            'name' => 'Dinda Kartika',
            'email' => 'dinda@example.test',
            'pendidikan_terakhir' => 'S1',
        ]);

        $this->actingAs($admin);

        $this->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('User Management')
            ->assertSee('Dinda Kartika')
            ->assertSee('dinda@example.test');
    }

    public function test_authenticated_users_can_create_a_package()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('admin.packages.store'), [
            'name' => 'SKD Premium Drill',
            'category' => 'kedinasan',
            'question_count' => 125,
            'participants_count' => 300,
            'price' => 175000,
            'status' => 'published',
            'icon' => 'graduation',
            'tone' => 'blue',
            'show_participant_preview' => '1',
        ]);

        $package = LearningPackage::query()->where('name', 'SKD Premium Drill')->firstOrFail();

        $response->assertRedirect(route('admin.packages.edit', $package));
        $this->assertDatabaseHas('learning_packages', [
            'name' => 'SKD Premium Drill',
            'slug' => 'skd-premium-drill',
            'category' => 'KEDINASAN',
            'status' => 'published',
            'show_participant_preview' => true,
        ]);
    }

    public function test_authenticated_users_can_update_a_package()
    {
        $user = User::factory()->create();
        $package = LearningPackage::factory()->create([
            'name' => 'Old Package Name',
            'slug' => 'old-package-name',
            'status' => 'draft',
        ]);

        $this->actingAs($user);

        $response = $this->put(route('admin.packages.update', $package), [
            'name' => 'Updated Package Name',
            'category' => 'career',
            'question_count' => 88,
            'participants_count' => 12,
            'price' => 225000,
            'status' => 'published',
            'icon' => 'briefcase',
            'tone' => 'muted',
        ]);

        $package->refresh();

        $response->assertRedirect(route('admin.packages.edit', $package));
        $this->assertSame('updated-package-name', $package->slug);
        $this->assertDatabaseHas('learning_packages', [
            'id' => $package->id,
            'name' => 'Updated Package Name',
            'category' => 'CAREER',
            'question_count' => 88,
            'status' => 'published',
        ]);
    }

    public function test_authenticated_users_can_delete_a_package()
    {
        $user = User::factory()->create();
        $package = LearningPackage::factory()->create();

        $this->actingAs($user);

        $response = $this->delete(route('admin.packages.destroy', $package));

        $response->assertRedirect(route('admin.packages.index'));
        $this->assertDatabaseMissing('learning_packages', [
            'id' => $package->id,
        ]);
    }

    public function test_admins_can_add_tryout_questions_to_a_package()
    {
        $admin = User::factory()->create();
        $package = LearningPackage::factory()->create([
            'name' => 'CPNS Question Bank',
            'slug' => 'cpns-question-bank',
        ]);

        $this->actingAs($admin);

        $response = $this->post(route('admin.packages.questions.store', $package), [
            'section' => 'TWK',
            'prompt' => 'Apa penerapan nilai Pancasila yang paling tepat dalam pelayanan publik?',
            'points' => 5,
            'is_active' => 1,
            'correct_label' => 'B',
            'answers' => [
                'A' => 'Mengutamakan kepentingan pribadi',
                'B' => 'Melayani warga dengan adil',
                'C' => 'Menunda layanan tanpa alasan',
                'D' => 'Mengabaikan antrean',
                'E' => 'Memilih warga tertentu',
            ],
        ]);

        $question = TryoutQuestion::query()->where('learning_package_id', $package->id)->firstOrFail();

        $response->assertRedirect(route('admin.packages.tryout', $package));
        $this->assertDatabaseHas('tryout_questions', [
            'id' => $question->id,
            'section' => 'TWK',
        ]);
        $this->assertDatabaseHas('tryout_answers', [
            'tryout_question_id' => $question->id,
            'label' => 'B',
            'is_correct' => true,
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Filament\Widgets\DeviceInsights;
use App\Models\Device;
use App\Models\DeviceCategory;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentInterfaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_graphs_handle_an_empty_fleet(): void
    {
        Livewire::test(DeviceInsights::class)
            ->assertSuccessful()
            ->assertViewHas('total', 0)
            ->assertViewHas('activePercentage', 0)
            ->assertSee('Add your first device')
            ->assertSee('No categories yet');
    }

    public function test_graphs_show_real_counts_and_refresh_without_changing_devices(): void
    {
        $category = DeviceCategory::create(['name' => 'Retail <printers>']);

        Device::create(['name' => 'Printer A', 'machine_number' => 'A', 'status' => true, 'device_category_id' => $category->id]);
        Device::create(['name' => 'Printer B', 'machine_number' => 'B', 'status' => false]);

        $widget = Livewire::test(DeviceInsights::class)
            ->assertViewHas('total', 2)
            ->assertViewHas('active', 1)
            ->assertViewHas('inactive', 1)
            ->assertViewHas('activePercentage', 50)
            ->assertViewHas('categories', fn ($categories) => $categories->pluck('count', 'name')->all() === [
                'Retail <printers>' => 1,
                'Uncategorized' => 1,
            ])
            ->assertSee('Retail &lt;printers&gt;', escape: false)
            ->assertSee('Uncategorized');

        Device::create(['name' => 'Printer C', 'machine_number' => 'C', 'status' => true]);

        $widget->call('$refresh')
            ->assertViewHas('total', 3)
            ->assertViewHas('activePercentage', 67);

        $this->assertDatabaseCount('devices', 3);
        $this->assertDatabaseHas('devices', ['machine_number' => 'B', 'status' => false, 'notified_7_at' => null]);
    }

    public function test_themed_admin_pages_render_and_remain_protected(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/admin/login')->assertOk()->assertSee('Fiscal Monitor');

        // The existing User model permits Filament access only in the local environment.
        config(['app.env' => 'local']);
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $this->actingAs(User::factory()->create());

        $this->get('/admin')->assertOk()->assertSee('A clearer view of every license.');

        foreach (['devices', 'device-categories', 'companies'] as $resource) {
            $this->get('/admin/'.$resource)
                ->assertOk()
                ->assertSee('Fiscal Monitor')
                ->assertDontSee('A clearer view of every license.');
        }
    }
}

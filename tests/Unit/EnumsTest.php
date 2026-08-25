<?php

declare(strict_types=1);

use App\Enum\Blogs\Status as BlogStatus;
use App\Enum\Notices\Status as NoticeStatus;
use App\Enum\Projects\Category;
use App\Enum\Projects\Status as ProjectStatus;

test('blog status enum exposes labels and colors', function (): void {
    expect(BlogStatus::Draft->getLabel())->toBe('Draft')
        ->and(BlogStatus::Draft->getColor())->toBe('gray')
        ->and(BlogStatus::Published->getLabel())->toBe('Published')
        ->and(BlogStatus::Published->getColor())->toBe('success');
});

test('notice status enum exposes labels, colors and icons', function (): void {
    expect(NoticeStatus::Draft->value)->toBe('Draft')
        ->and(NoticeStatus::Draft->getLabel())->toBe('Draft')
        ->and(NoticeStatus::Draft->getColor())->toBe('gray')
        ->and(NoticeStatus::Draft->getIcon())->toBe('heroicon-o-newspaper')
        ->and(NoticeStatus::Published->getLabel())->toBe('Published')
        ->and(NoticeStatus::Published->getColor())->toBe('success')
        ->and(NoticeStatus::Published->getIcon())->toBe('heroicon-o-check-badge')
        ->and(NoticeStatus::Unpublished->getLabel())->toBe('Unpublished')
        ->and(NoticeStatus::Unpublished->getColor())->toBe('danger')
        ->and(NoticeStatus::Unpublished->getIcon())->toBe('heroicon-o-times-circle');
});

test('project status enum exposes labels and colors', function (): void {
    expect(ProjectStatus::Draft->getLabel())->toBe('Draft')
        ->and(ProjectStatus::Draft->getColor())->toBe('gray')
        ->and(ProjectStatus::Published->getLabel())->toBe('Published')
        ->and(ProjectStatus::Published->getColor())->toBe('success')
        ->and(ProjectStatus::Archived->getLabel())->toBe('Archived')
        ->and(ProjectStatus::Archived->getColor())->toBe('warning');
});

test('project category enum exposes labels, colors and icons', function (): void {
    expect(Category::Cdsp->value)->toBe('cdsp')
        ->and(Category::Cdsp->getLabel())->toBe('CDSP')
        ->and(Category::Cdsp->getColor())->toBe('blue')
        ->and(Category::Cdsp->getIcon())->toBe('heroicon-o-building-office-2')
        ->and(Category::Wdp->value)->toBe('wdp')
        ->and(Category::Wdp->getLabel())->toBe('WDP')
        ->and(Category::Wdp->getColor())->toBe('green')
        ->and(Category::Wdp->getIcon())->toBe('heroicon-o-globe-alt');
});

import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CryptoHeatmapComponent } from './crypto-heatmap.component';

describe('CryptoHeatmapComponent', () => {
  let component: CryptoHeatmapComponent;
  let fixture: ComponentFixture<CryptoHeatmapComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CryptoHeatmapComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(CryptoHeatmapComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

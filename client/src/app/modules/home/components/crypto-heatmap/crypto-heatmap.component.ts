import { AfterViewInit, ElementRef, Renderer2, ViewChild, Component } from '@angular/core';


@Component({
  selector: 'app-crypto-heatmap',
  standalone: true,
  imports: [],
  templateUrl: './crypto-heatmap.component.html',
  styleUrl: './crypto-heatmap.component.css'
})
export class CryptoHeatmapComponent implements AfterViewInit {

  @ViewChild('tradingview') tradingview?: ElementRef;

  constructor(private _renderer2: Renderer2) {}

  ngAfterViewInit(): void {
    let script = this._renderer2.createElement('script');
    script.type = `text/javascript`;
    script.src = "https://s3.tradingview.com/external-embedding/embed-widget-crypto-coins-heatmap.js";
    script.text = `
    {
      "dataSource": "Crypto",
      "blockSize": "market_cap_calc",
      "blockColor": "change",
      "locale": "en",
      "symbolUrl": "",
      "colorTheme": "light",
      "hasTopBar": false,
      "isDataSetEnabled": false,
      "isZoomEnabled": true,
      "hasSymbolTooltip": true,
      "width": "1410",
      "height": "400"
    }`;
  
    this.tradingview?.nativeElement.appendChild(script);
  }
}

import { AfterViewInit, ElementRef, Renderer2, ViewChild, Component, Input } from '@angular/core';

@Component({
  selector: 'app-symbol-overview',
  standalone: true,
  templateUrl: './symbol-overview.component.html',
  styleUrl: './symbol-overview.component.css'
})
export class SymbolOverviewComponent implements AfterViewInit {
  @Input() ticker: string;
  @Input() stock: string;

  @ViewChild('tradingview') tradingview?: ElementRef;

  constructor(private _renderer2: Renderer2) { 
    this.ticker = '';
    this.stock = '';
  }

  ngAfterViewInit(): void {
    let script = this._renderer2.createElement('script');
    script.type = `text/javascript`;
    script.src = "https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js";
    script.text = `
    {
      "symbols": [
        [
          "${this.stock}",
          "${this.ticker}|1D"
        ]
      ],
      "chartOnly": true,
      "width": "1410",
      "height": "400",
      "locale": "en",
      "colorTheme": "light",
      "autosize": false,
      "showVolume": false,
      "showMA": false,
      "hideDateRanges": false,
      "hideMarketStatus": false,
      "hideSymbolLogo": false,
      "scalePosition": "right",
      "scaleMode": "Normal",
      "fontFamily": "-apple-system, BlinkMacSystemFont, Trebuchet MS, Roboto, Ubuntu, sans-serif",
      "fontSize": "10",
      "noTimeScale": false,
      "valuesTracking": "1",
      "changeMode": "price-and-percent",
      "chartType": "area",
      "maLineColor": "#2962FF",
      "maLineWidth": 1,
      "maLength": 9,
      "lineWidth": 2,
      "lineType": 0,
      "dateRanges": [
        "1d|1",
        "1m|30",
        "3m|60",
        "12m|1D",
        "60m|1W",
        "all|1M"
      ]
    }`;
  
    this.tradingview?.nativeElement.appendChild(script);
  }
}
import { AfterViewInit, ElementRef, Renderer2, ViewChild, Component } from '@angular/core';

@Component({
  selector: 'app-ticker-tape',
  standalone: true,
  templateUrl: './ticker-tape.component.html',
  styleUrl: './ticker-tape.component.css'
})

export class TickerTapeComponent implements AfterViewInit {

  @ViewChild('tradingview') tradingview?: ElementRef;

  constructor(private _renderer2: Renderer2) { }

  ngAfterViewInit(): void {
    let script = this._renderer2.createElement('script');
    script.type = `text/javascript`;
    script.src = "https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js";
    script.text = `
    {
      "symbols": [
        {
          "proName": "FOREXCOM:SPXUSD",
          "title": "S&P 500 Index"
        },
        {
          "description": "Tesla",
          "proName": "NASDAQ:TSLA"
        },
        {
          "description": "Apple Inc",
          "proName": "NASDAQ:AAPL"
        },
        {
          "description": "Nvidia",
          "proName": "NASDAQ:NVDA"
        },
        {
          "description": "Microsoft",
          "proName": "NASDAQ:MSFT"
        },
        {
          "description": "Advanced Micro Devices",
          "proName": "NASDAQ:AMD"
        },
        {
          "description": "Meta",
          "proName": "NASDAQ:META"
        },
        {
          "description": "Netflix",
          "proName": "NASDAQ:NFLX"
        },
        {
          "proName": "BITSTAMP:BTCUSD",
          "title": "Bitcoin"
        },
        {
          "proName": "BITSTAMP:ETHUSD",
          "title": "Ethereum"
        },
        {
          "description": "WTI CRUDE OIL",
          "proName": "TVC:USOIL"
        },
        {
          "description": "GOLD",
          "proName": "OANDA:XAUUSD"
        }
      ],
      "showSymbolLogo": true,
      "isTransparent": false,
      "displayMode": "compact",
      "colorTheme": "light",
      "locale": "en"
      }`;
  
    this.tradingview?.nativeElement.appendChild(script);
  }
}

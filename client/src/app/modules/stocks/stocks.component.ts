import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { NavbarComponent } from '../../shared/navbar/navbar.component';
import { StockService } from '../../services/stock.service';
import { Stock } from '../../models/stock';
import { WatchlistStockService } from '../../services/watchlist-stock.service';

@Component({
  selector: 'app-stocks',
  standalone: true,
  imports: [NavbarComponent],
  templateUrl: './stocks.component.html',
  styleUrl: './stocks.component.css'
})
export class StocksComponent {
  ticker: string;
  stock: Stock | undefined;

  constructor(private activatedRoute: ActivatedRoute, private stockService: StockService, private watchlistStockService: WatchlistStockService) {
    this.ticker = this.activatedRoute.snapshot.params['ticker'];
  }

  ngOnInit(): void {
    this.fetchStocks(this.ticker);
  }

  fetchStocks(ticker: string): void {
    this.stockService.getStock(ticker).subscribe({
      next: data => {
        this.stock = data.results;
      },
      error: err => {
        console.log(err);
      }
    });
  }

  addStockToWatchlist(ticker: string) {
    this.watchlistStockService.addStockToWatchlist(1, ticker).subscribe({
      next: data => {
        console.log(data);
      },
      error: err => {
        console.log(err);
      }
    });
  }
}

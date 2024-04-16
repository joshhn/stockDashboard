import { Component } from '@angular/core';
import { CommonModule, NgFor, NgIf } from '@angular/common';
import { ActivatedRoute } from '@angular/router';
import { User } from '../../models/user';
import { Watchlist } from '../../models/watchlist';
import { Stock } from '../../models/stock';
import { NavbarComponent } from '../../shared/navbar/navbar.component';
import { StockService } from '../../services/stock.service';
import { WatchlistStockService } from '../../services/watchlist-stock.service';
import { WatchlistService } from '../../services/watchlist.service';
import { StorageService } from '../../services/storage.service';

@Component({
  selector: 'app-stocks',
  standalone: true,
  imports: [CommonModule, NgIf, NgFor, NavbarComponent],
  templateUrl: './stocks.component.html',
  styleUrl: './stocks.component.css'
})
export class StocksComponent {
  ticker: string;
  stock: Stock;
  isLoggedIn: boolean;
  user: User | null;
  watchlists: Watchlist[];

  constructor(
      private activatedRoute: ActivatedRoute,
      private stockService: StockService,
      private watchlistService: WatchlistService,
      private watchlistStockService: WatchlistStockService,
      private storageService: StorageService
  ) {
    this.ticker = this.activatedRoute.snapshot.params['ticker'];
    this.stock = { ticker: this.ticker, name: '' };
    this.isLoggedIn = this.storageService.isLoggedIn();
    this.user = this.storageService.getUser();
    this.watchlists = []
  }

  ngOnInit(): void {
    this.fetchStocks(this.ticker);
    if(this.user) {
      this.fetchWatchlists();
    }
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

  fetchWatchlists() {
    this.watchlistService.getWatchlists().subscribe({
      next: data => {
        this.watchlists = data;
      },
      error: err => {
        console.log(err);
      }
    })
  }

  addStockToWatchlist(id: number) {
    this.watchlistStockService.addStockToWatchlist(id, this.ticker).subscribe({
      next: data => {
        const index = this.watchlists.findIndex(wl => wl.id === id);
        if (index !== -1) {
          this.watchlists[index].stocks.push(this.stock);
        }
      },
      error: err => {
        console.log(err);
      }
    });
  }

  removeStockFromWatchlist(id: number) {
    this.watchlistStockService.removeStockFromWatchlist(id, this.ticker).subscribe({
      next: data => {
        const index = this.watchlists.findIndex(wl => wl.id === id);
        if (index !== -1) {
          this.watchlists[index].stocks = this.watchlists[index].stocks.filter(stock => stock.ticker !== this.ticker);
        }
      },
      error: err => {
        console.log(err);
      }
    });
  }

  openPage(): void {
    window.open(this.stock.homepage_url, '_blank');
  }

  watchlistHasTicker(watchlist: Watchlist) {
    return watchlist.stocks.some(stock => stock.ticker === this.ticker);
  }
}

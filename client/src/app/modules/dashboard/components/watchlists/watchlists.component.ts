import { Component } from '@angular/core';
import { NgFor, NgIf } from '@angular/common';
import { Watchlist } from '../../../../models/watchlist';
import { WatchlistService } from '../../../../services/watchlist.service';
import { WatchlistStockService } from '../../../../services/watchlist-stock.service';
import { EditModalComponent } from '../edit-modal/edit-modal.component';

@Component({
  selector: 'app-watchlists',
  standalone: true,
  imports: [NgFor, NgIf, EditModalComponent],
  templateUrl: './watchlists.component.html',
  styleUrl: './watchlists.component.css'
})
export class WatchlistsComponent {
  watchlists: Watchlist[];
  errorMessage: string;
  expandedIds: Set<number>;
  isModalVisible: boolean;
  currentWatchlistId: number;

  constructor(private watchlistService: WatchlistService, private watchlistStockService: WatchlistStockService) {
    this.watchlists = [];
    this.errorMessage = '';
    this.expandedIds = new Set<number>();
    this.isModalVisible = false;
    this.currentWatchlistId = -1;
  }

  ngOnInit() {
    this.watchlistService.getWatchlists().subscribe({
      next: data => {
        this.watchlists = data;
        console.log(data)
      },
      error: err => {
        console.log(err);
      }
    });
  }

  toggleExpansion(id: number) {
    if (this.expandedIds.has(id)) {
      this.expandedIds.delete(id);
    } else {
      this.expandedIds.add(id);
    }
  }

  createWatchlist() {
    this.watchlistService.create('Testname').subscribe({
      next: data => {
        this.watchlists.push(data);
      },
      error: err => {
        console.log(err);
      }
    });
  }

  removeStockFromWatchlist(watchlistId: number, ticker: string) {
    this.watchlistStockService.removeStockFromWatchlist(watchlistId, ticker).subscribe({
      next: data => {
        const watchlist = this.watchlists.find(wl => wl.id === watchlistId);
        if (watchlist) {
          watchlist.stocks = watchlist.stocks.filter(s => s.ticker !== ticker);
        }
      },
      error: err => {
        console.log(err);
      }
    });
  }

  getCurrentWatchlistName(): string {
    const currentWatchlist = this.watchlists.find(w => w.id === this.currentWatchlistId);
    return currentWatchlist ? currentWatchlist.name : '';
  }

  openModal(id: number) {
    this.isModalVisible = true;
    this.currentWatchlistId = id;
  }

  closeModal() {
    this.isModalVisible = false;
    this.currentWatchlistId = -1;
  }

  deleteWatchlist() {
    this.closeModal();
  }

  editWatchlist(name: string) {
    this.watchlistService.update(this.currentWatchlistId, name).subscribe({
      next: data => {
        const index = this.watchlists.findIndex(wl => wl.id === data.id);
        if (index !== -1) {
          this.watchlists[index] = data;
        }
      },
      error: err => {
        console.log(err);
      }
    });
    this.closeModal();
  }

  addStock(stock: string) {
    this.closeModal();
  }
}

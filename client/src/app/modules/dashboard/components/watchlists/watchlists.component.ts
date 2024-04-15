import { Component } from '@angular/core';
import { NgFor, NgIf } from '@angular/common';
import { Watchlist } from '../../../../models/watchlist';
import { WatchlistService } from '../../../../services/watchlist.service';

@Component({
  selector: 'app-watchlists',
  standalone: true,
  imports: [NgFor, NgIf],
  templateUrl: './watchlists.component.html',
  styleUrl: './watchlists.component.css'
})
export class WatchlistsComponent {
  watchlists: Watchlist[];
  errorMessage: string;
  expandedIds: Set<number>;

  constructor(private watchlistService: WatchlistService) {
    this.watchlists = [];
    this.errorMessage = '';
    this.expandedIds = new Set<number>();
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


  toggleExpansion(id: number) {
    if (this.expandedIds.has(id)) {
      this.expandedIds.delete(id);
    } else {
      this.expandedIds.add(id);
    }
  }
}

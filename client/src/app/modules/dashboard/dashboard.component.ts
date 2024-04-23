import { Component } from '@angular/core';
import { RouterModule } from '@angular/router';
import { NgIf } from '@angular/common';
import { StorageService } from '../../services/storage.service';
import { NavbarComponent } from '../../shared/navbar/navbar.component';
import { TickerTapeComponent } from '../../shared/ticker-tape/ticker-tape.component';
import { User } from '../../models/user';
import { AuthService } from '../../services/auth.service';
import { WatchlistsComponent } from './components/watchlists/watchlists.component';

@Component({
  selector: 'app-dashboard',
  standalone: true,
  imports: [RouterModule, NgIf, NavbarComponent, WatchlistsComponent, TickerTapeComponent],
  templateUrl: './dashboard.component.html',
  styleUrl: './dashboard.component.css'
})
export class DashboardComponent {
  isLoggedIn: boolean;
  user: User | null;
  errorMessage: string;

  constructor(private authService: AuthService, private storageService: StorageService) {
    this.isLoggedIn = this.storageService.isLoggedIn();
    this.errorMessage = '';
    this.user = this.storageService.getUser();
  }

  logout(): void {
    this.authService.logout().subscribe({
      next: res => {
        this.storageService.clean();
        window.location.reload();
      },
      error: err => {
        console.log(err);
      }
    });
  }
}

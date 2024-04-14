import { Component } from '@angular/core';
import { RouterModule } from '@angular/router';
import { NgIf } from '@angular/common';
import { StorageService } from '../../services/storage.service';
import { NavbarComponent } from '../../shared/navbar/navbar.component';
import { User } from '../../models/user';
import { AuthService } from '../../services/auth.service';
import { WatchlistComponent } from './components/watchlist/watchlist.component';

@Component({
  selector: 'app-account',
  standalone: true,
  imports: [RouterModule, NgIf, NavbarComponent, WatchlistComponent],
  templateUrl: './account.component.html',
  styleUrl: './account.component.css'
})
export class AccountComponent {
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

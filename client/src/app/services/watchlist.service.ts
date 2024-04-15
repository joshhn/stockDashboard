import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { StorageService } from './storage.service';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';
import { Watchlist } from '../models/watchlist';

@Injectable({
  providedIn: 'root'
})
export class WatchlistService {
  token: string | undefined;
  headerOptions: {};

  constructor(private http: HttpClient, private storageService: StorageService) {
    this.token = this.storageService.getUser()?.token;
    this.headerOptions = { headers: {Authorization: `Bearer ${this.token}`}};
  }

  getWatchlists(): Observable<Watchlist[]> {
    return this.http.get<Watchlist[]>(`${environment.apiUrl}/watchlists`, this.headerOptions);
  }

  create(name: string): Observable<any> {
    return this.http.post<Watchlist>(`${environment.apiUrl}/watchlists`, {name}, this.headerOptions);
  }

  update(id: number, name: string): Observable<Watchlist> {
    return this.http.put<Watchlist>(`${environment.apiUrl}/watchlists/${id}`, {name}, this.headerOptions);
  }
  
  delete(id: number): Observable<any> {
    return this.http.delete(`${environment.apiUrl}/watchlists/${id}`, this.headerOptions);
  }
}

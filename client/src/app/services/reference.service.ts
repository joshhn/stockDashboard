import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { StorageService } from './storage.service';
import { News } from '../models/news';
import { environment } from '../../environments/environment';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ReferenceService {
  constructor(private http: HttpClient) {}

  getNews(): Observable<any> {
    return this.http.get(`${environment.apiUrl}/reference/news`);
  }
}

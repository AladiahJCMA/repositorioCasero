import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { User } from '../types';

@Injectable({
  providedIn: 'root'
})
export class SharedDataService {

  public data = new BehaviorSubject<User|null>(null);

  constructor() { }
}

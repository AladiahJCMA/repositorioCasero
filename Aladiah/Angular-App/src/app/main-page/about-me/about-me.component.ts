import { Component, OnDestroy, OnInit } from '@angular/core';

@Component({
  selector: 'app-about-me',
  templateUrl: './about-me.component.html',
  styleUrls: ['./about-me.component.css']
})
export class AboutMeComponent implements OnInit, OnDestroy {
  body: HTMLElement | null = null;

  ngOnInit(): void {
    this.body = document.getElementById('main-body')!;
    this.body.style.overflowY = 'hidden';
  }

  ngOnDestroy(): void {
    this.body = document.getElementById('main-body')!;
    this.body.style.overflowY = 'auto';
  }

}

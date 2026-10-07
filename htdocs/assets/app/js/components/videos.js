export class VideosInitializer {
  constructor({ container, videoClass, clicked }) {
    this.container = container;
    this.videoClass = videoClass;
    this.videosContainers = [];
    this.activeVideoContainer = null;
    this.activeVideo = null;
    this.preloader = null;
    this.activeIndex = 0;
    this.initializingClass = 'initializing';
    this.isClicked = clicked;
    // this.inViewIts = [];
    this.observer = null;
    this.videoClickHandler = this.videoClickHandler.bind(this);
    this.loadedVideoHandler = this.loadedVideoHandler.bind(this);
    this.loadFrameHandler = this.loadFrameHandler.bind(this);
    this.intersectionCallback = this.intersectionCallback.bind(this);
    this.init();
  }

  init() {
    this.videosContainers = this.container.querySelectorAll(this.videoClass);
    this.videosContainers.forEach((item) => item.addEventListener('click', this.videoClickHandler));
    // this.inViewIts = [...this.videosContainers].filter((item) => item.dataset.videoView === 'inView');
    if (!this.isClicked) {
      this.observer = new IntersectionObserver(this.intersectionCallback)
      this.videosContainers.forEach((item) => this.observer.observe(item));
    }
  }

  videoPause(video) {
    if (video.paused) {
      this.startActiveVideo(video);
    } else {
      this.stopActiveVideo(video);
    }
  }

  stopActiveVideo(video) {
    if (video) {
      video.pause();
      this.removeActiveElts()
    }
  }

  startActiveVideo(video) {
    if (video) {
      video.play();
      this.setActiveElts();
    }
  }

  intersectionCallback(entries, observer) {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        this.initVideo(entry.target);
      } else {
        let video = entry.target.querySelector('video');
        this.stopActiveVideo(video)
      }
    });
  }

  setActiveElts() {
    this.activeIndex = [...this.videosContainers].indexOf(this.activeVideoContainer);
    this.activeVideoContainer.classList.add('active');
    if (this.activeIndex !== 0) this.videosContainers[this.activeIndex - 1].classList.add('next')
    if (this.activeIndex !== this.videosContainers.length - 1) this.videosContainers[this.activeIndex + 1].classList.add('next')
  }

  removeActiveElts() {
    this.activeVideoContainer.classList.remove('active');
    if (this.activeIndex !== 0) this.videosContainers[this.activeIndex - 1].classList.remove('next')
    if (this.activeIndex !== this.videosContainers.length - 1) this.videosContainers[this.activeIndex + 1].classList.remove('next')
  }

  videoClickHandler(evt) {
    const target = evt.target;
    const type = evt.type;
    const videoContainer = target.closest(this.videoClass);
    this.initVideo(videoContainer, type);
  }

  initVideo(videoContainer, evtType) {
    if (videoContainer.classList.contains(this.initializingClass)) return;
    const video = videoContainer.querySelector('video');
    this.activeVideoContainer = videoContainer;
    if (video && !this.activeVideoContainer.classList.contains('active')) {
      this.videoPause(this.activeVideo);
      this.activeVideo = video;
      this.startActiveVideo(this.activeVideo);

    } else if (video && this.activeVideoContainer.classList.contains('active')) {
      this.videoPause(video)
      // this.activeVideo = null;
    }

    if (!Boolean(video)) {
      this.stopActiveVideo(this.activeVideo);
      this.createVideo(videoContainer);
    }
  }

  createVideo(videoContainer) {
    this.activeVideoContainer = videoContainer;
    this.createPreloader();
    const link = this.activeVideoContainer.dataset.video;
    this.activeVideo = document.createElement('video');
    this.activeVideo.src = link;
    this.activeVideo.setAttribute('autoplay', true);
    if (!this.isClicked) { 
      this.activeVideo.setAttribute('muted', 'muted'); 
      this.activeVideo.volume = 0;
    } else {
      this.activeVideo.volume = 0.5;
    }
    this.activeVideo.setAttribute('controls', true);
    this.activeVideo.setAttribute('playsinline', true);
    this.activeVideo.addEventListener('loadeddata', this.loadedVideoHandler)
    this.setActiveElts();
  }

  createPreloader() {
    this.preloader = document.createElement('div');
    this.preloader.classList.add('circle-spin-3');
    this.activeVideoContainer.append(this.preloader);
    this.activeVideoContainer.classList.add(this.initializingClass);
  }

  loadFrameHandler(evt) {
    this.removePreloader();
  }

  loadedVideoHandler(evt) {
    if (this.activeVideoContainer.classList.contains(this.initializingClass)) this.activeVideoContainer.classList.remove(this.initializingClass);
    this.activeVideoContainer.append(this.activeVideo);
    this.activeVideoContainer.classList.add('has-video')
    this.activeVideo.play();
    const isPlaying = !!(this.activeVideo.currentTime > 0 && !this.activeVideo.paused && !this.activeVideo.ended && this.activeVideo.readyState > 2);
    if (isPlaying) {
      this.activeVideoContainer.classList.add('active');
    }
    this.removePreloader();
    this.activeVideo.removeEventListener('loadeddata', this.loadedVideoHandler)
  }

  removePreloader() {
    if (this.preloader) {
      this.preloader.remove();
      this.preloader = null;
    }
    this.activeVideoContainer.classList.remove(this.initializingClass);
  }
}
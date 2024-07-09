<?php
    class Media {
        private ?int $id = null;
        public function __construct(private string $name, private string $url)
        {
        }

        public function getId(): ?int{
            return $this->id;
        }

        public function setId(int $id): void{
            $this->id = $id;
        }

        public function getName(): string{
            return $this->name;
        }
        public function setName(string $name): void{
            $this->name = $name;
        }
        public function getUrl(): string{
            return $this->url;
        }
        public function setUrl(string $url): void{
            $this->url = $url;
        }
    }
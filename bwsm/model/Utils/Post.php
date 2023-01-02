<?php 
class Post {
    private string $Content;
    private int $PosterID;
    private int $PosterProFilePictureUrl;
    private int $PostID;
    private int $NumberOFlikes;
    private string $PosterName;
     

	/**
	 * @return string
	 */
	public function getContent(): string {
		return $this->Content ?? "";
	}
	
	/**
	 * @param string $Content 
	 * @return self
	 */
	public function setContent(string $Content): self {
		$this->Content = $Content ?? "";
        $this->NumberOFlikes =$Content["NUMBER_OF_LIKES"] ?? 0;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getPostID(): int {
		return $this->PostID;
	}
	
	/**
	 * @param int $PostID 
	 * @return self
	 */
	public function setPostID(int $PostID): self {
		$this->PostID = $PostID;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getNumberOFlikes(): int {
		return $this->NumberOFlikes;
	}
	
	

	/**
	 * @return string
	 */
	public function getPosterName(): string {
		return $this->PosterName;
	}
	
	/**
	 * @param string $PosterName 
	 * @return self
	 */
	public function setPosterName(string $PosterName): self {
		$this->PosterName = $PosterName;
		return $this;
	}

	/**
	 * @param int $NumberOFlikes 
	 * @return self
	 */
	public function setNumberOFlikes(int $NumberOFlikes): self {
		$this->NumberOFlikes = $NumberOFlikes;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getPosterID(): int {
		return $this->PosterID;
	}
	
	/**
	 * @param int $PosterID 
	 * @return self
	 */
	public function setPosterID(int $PosterID): self {
		$this->PosterID = $PosterID;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getPosterProFilePictureUrl(): int {
		return $this->PosterProFilePictureUrl;
	}
	
	/**
	 * @param int $PosterProFilePictureUrl 
	 * @return self
	 */
	public function setPosterProFilePictureUrl(int $PosterProFilePictureUrl): self {
		$this->PosterProFilePictureUrl = $PosterProFilePictureUrl;
		return $this;
	}
}
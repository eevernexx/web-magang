                                                    <div class="position-relative" style="display:inline-block;">
                                                        <img src="{{ url('/storage/foto_tugas/' . basename($image->image_path)) }}" 
                                                             alt="Foto Tugas" 
                                                             class="img-thumbnail" 
                                                             style="width: 100px; height: 100px; object-fit: cover;">
                                                        <button type="button" 
                                                                class="btn btn-danger btn-sm position-absolute" 
                                                                style="top:2px; right:2px; z-index:2; padding:2px 6px; border-radius:50%;"
                                                                onclick="deleteImage({{ $image->id }})">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div> 
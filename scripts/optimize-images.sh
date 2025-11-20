#!/usr/bin/env bash

# ============================================================
#   ADVANCED IMAGE OPTIMIZER (Windows Git Bash Compatible)
#   Final fully patched version (Option A output structure)
# ============================================================

RED="\033[0;31m"
GREEN="\033[0;32m"
YELLOW="\033[1;33m"
BLUE="\033[0;34m"
NC="\033[0m"

QUALITY=82
SIZES=(300 600 900 1200)

GENERATE_JPG=true
GENERATE_WEBP=true
FORCE=false
QUIET=false

THUMB_SIZE=0
THUMB_SQUARE=false
THUMB_ONLY=false
NO_THUMB=false

MOBILE_SIZE=0
MOBILE_PORTRAIT=false
MOBILE_LANDSCAPE=false
MOBILE_SQUARE=false
MOBILE_ONLY=false

SNIPPET_OUT=""


# --------------------------
# Hard-require ImageMagick "magick"
# --------------------------
if ! command -v magick >/dev/null 2>&1; then
  echo -e "${RED}❌ ImageMagick 'magick' not found.${NC}"
  echo -e "${YELLOW}➡ Please install ImageMagick and add to PATH.${NC}"
  exit 1
else
  echo -e "${GREEN}✔ ImageMagick detected${NC}"
fi

if ! command -v cwebp >/dev/null 2>&1; then
  echo -e "${RED}❌ WebP encoder 'cwebp' not found.${NC}"
  echo -e "${YELLOW}➡ Install it and add folder to PATH.${NC}"
  exit 1
else
  echo -e "${GREEN}✔ WebP encoder detected${NC}"
fi


# --------------------------
# Normalize Windows paths
# --------------------------
normalize_path() { echo "${1//\\//}"; }


# --------------------------
# Generate alt text from filename
# --------------------------
generate_alt_text() {
  local alt="${1//[-_]/ }"
  alt="${alt,,}"
  sed 's/\b\(.\)/\u\1/g' <<< "$alt"
}


# --------------------------
# Argument parser
# --------------------------
while [[ "$1" == --* ]]; do
  case "$1" in
    --sizes) IFS=',' read -ra SIZES <<< "$2"; shift 2 ;;
    --quality) QUALITY="$2"; shift 2 ;;
    --webp-only) GENERATE_JPG=false; GENERATE_WEBP=true; shift ;;
    --jpg-only) GENERATE_JPG=true; GENERATE_WEBP=false; shift ;;
    --force) FORCE=true; shift ;;
    --quiet) QUIET=true; shift ;;
    --thumb) THUMB_SIZE="$2"; shift 2 ;;
    --square) THUMB_SQUARE=true; shift ;;
    --thumb-only) THUMB_ONLY=true; shift ;;
    --no-thumb) NO_THUMB=true; shift ;;
    --mobile) MOBILE_SIZE="$2"; shift 2 ;;
    --mobile-portrait) MOBILE_PORTRAIT=true; shift ;;
    --mobile-landscape) MOBILE_LANDSCAPE=true; shift ;;
    --mobile-square) MOBILE_SQUARE=true; shift ;;
    --mobile-only) MOBILE_ONLY=true; shift ;;
    --output-snippet) SNIPPET_OUT="$2"; shift 2 ;;
    --help)
      echo "Usage: optimize-images.sh [flags] <image_or_folder>"
      exit 0
    ;;
    *) echo -e "${RED}Unknown flag: $1${NC}"; exit 1 ;;
  esac
done


# ============================================================
# RESIZE HELPERS (Windows-safe, uses correct syntax)
# ============================================================

# ------- Normal resize: WIDTH x 0 --------
resize_jpg() {
  magick "$1" -resize "${2}x0" -quality "$QUALITY" "$3"
}

resize_webp() {
  cwebp -q "$QUALITY" "$1" -resize "$2" 0 -o "$3"
}


# ============================================================
# THUMBNAIL GENERATOR
# ============================================================
generate_thumbnail() {
  local img="$1" name="$2" ext="$3" outdir="$4"
  local thumb_dir="$outdir/thumb"
  mkdir -p "$thumb_dir"

  local jpg="$thumb_dir/${name}-thumb-${THUMB_SIZE}.${ext}"
  local webp="$thumb_dir/${name}-thumb-${THUMB_SIZE}.webp"

  [ "$QUIET" = false ] && echo -e "${BLUE}--- Thumbnail: ${THUMB_SIZE}px ---${NC}"

  # JPG
  if [[ ! -f "$jpg" || "$FORCE" = true ]]; then
    if [ "$THUMB_SQUARE" = true ]; then
      magick "$img" -resize "${THUMB_SIZE}x${THUMB_SIZE}^" -gravity center -extent "${THUMB_SIZE}x${THUMB_SIZE}" -quality "$QUALITY" "$jpg"
    else
      magick "$img" -resize "${THUMB_SIZE}x0" -quality "$QUALITY" "$jpg"
    fi
    [ "$QUIET" = false ] && echo -e "  ${GREEN}✔ Thumbnail JPG created${NC}"
  fi

  # WebP
  if [[ ! -f "$webp" || "$FORCE" = true ]]; then
    if [ "$THUMB_SQUARE" = true ]; then
      cwebp -q "$QUALITY" "$img" -resize "$THUMB_SIZE" "$THUMB_SIZE" -o "$webp"
    else
      cwebp -q "$QUALITY" "$img" -resize "$THUMB_SIZE" 0 -o "$webp"
    fi
    [ "$QUIET" = false ] && echo -e "  ${GREEN}✔ Thumbnail WebP created${NC}"
  fi
}


# ============================================================
# MOBILE CROPS (portrait / landscape / square)
# ============================================================
generate_mobile_crop() {
  local img="$1" name="$2" ext="$3" outdir="$4"
  local dir="$outdir/mobile"
  mkdir -p "$dir"
  local w="$MOBILE_SIZE"

  # Portrait (4:5)
  if [ "$MOBILE_PORTRAIT" = true ]; then
    local h=$(( w * 5 / 4 ))
    magick "$img" -resize "${w}x${h}^" -gravity center -extent "${w}x${h}" "${dir}/${name}-mobile-${w}-portrait.${ext}"
    cwebp -q "$QUALITY" "$img" -resize "$w" "$h" -o "${dir}/${name}-mobile-${w}-portrait.webp"
    [ "$QUIET" = false ] && echo -e "${GREEN}✔ Mobile portrait created${NC}"
  fi

  # Landscape (16:9)
  if [ "$MOBILE_LANDSCAPE" = true ]; then
    local h=$(( w * 9 / 16 ))
    magick "$img" -resize "${w}x${h}^" -gravity center -extent "${w}x${h}" "${dir}/${name}-mobile-${w}-landscape.${ext}"
    cwebp -q "$QUALITY" "$img" -resize "$w" "$h" -o "${dir}/${name}-mobile-${w}-landscape.webp"
    [ "$QUIET" = false ] && echo -e "${GREEN}✔ Mobile landscape created${NC}"
  fi

  # Square (1:1)
  if [ "$MOBILE_SQUARE" = true ]; then
    magick "$img" -resize "${w}x${w}^" -gravity center -extent "${w}x${w}" "${dir}/${name}-mobile-${w}-square.${ext}"
    cwebp -q "$QUALITY" "$img" -resize "$w" "$w" -o "${dir}/${name}-mobile-${w}-square.webp"
    [ "$QUIET" = false ] && echo -e "${GREEN}✔ Mobile square created${NC}"
  fi
}


# ============================================================
# HTML SNIPPET (no trailing commas)
# ============================================================
build_html_snippet() {
  local name="$1" ext="$2" outdir="$3"
  local base="/${outdir#./}"
  local alt; alt=$(generate_alt_text "$name")

  echo "<picture>"

  # -- MOBILE SOURCES --
  if [ "$MOBILE_SIZE" -gt 0 ]; then
    [ "$MOBILE_PORTRAIT" = true ] && echo "  <source media=\"(max-width:600px)\" srcset=\"${base}/mobile/${name}-mobile-${MOBILE_SIZE}-portrait.webp\" type=\"image/webp\">"
    [ "$MOBILE_PORTRAIT" = true ] && echo "  <source media=\"(max-width:600px)\" srcset=\"${base}/mobile/${name}-mobile-${MOBILE_SIZE}-portrait.${ext}\">"

    [ "$MOBILE_LANDSCAPE" = true ] && echo "  <source media=\"(max-width:600px)\" srcset=\"${base}/mobile/${name}-mobile-${MOBILE_SIZE}-landscape.webp\" type=\"image/webp\">"
    [ "$MOBILE_LANDSCAPE" = true ] && echo "  <source media=\"(max-width:600px)\" srcset=\"${base}/mobile/${name}-mobile-${MOBILE_SIZE}-landscape.${ext}\">"

    [ "$MOBILE_SQUARE" = true ] && echo "  <source media=\"(max-width:600px)\" srcset=\"${base}/mobile/${name}-mobile-${MOBILE_SIZE}-square.webp\" type=\"image/webp\">"
    [ "$MOBILE_SQUARE" = true ] && echo "  <source media=\"(max-width:600px)\" srcset=\"${base}/mobile/${name}-mobile-${MOBILE_SIZE}-square.${ext}\">"
  fi

  # WEBP SRCSET (clean no trailing commas)
  echo "  <source type=\"image/webp\" srcset=\""
  for ((i=0; i<${#SIZES[@]}; i++)); do
    local s="${SIZES[$i]}"
    if (( i == ${#SIZES[@]}-1 )); then
      echo "      ${base}/${name}-${s}.webp ${s}w"
    else
      echo "      ${base}/${name}-${s}.webp ${s}w,"
    fi
  done
  echo "  \">"

  # JPG/PNG fallback
  echo "  <img"
  echo "    src=\"${base}/${name}-${SIZES[-1]}.${ext}\""
  echo "    srcset=\""
  for ((i=0; i<${#SIZES[@]}; i++)); do
    local s="${SIZES[$i]}"
    if (( i == ${#SIZES[@]}-1 )); then
      echo "      ${base}/${name}-${s}.${ext} ${s}w"
    else
      echo "      ${base}/${name}-${s}.${ext} ${s}w,"
    fi
  done
  echo "    \""
  echo "    sizes=\"100vw\""
  echo "    alt=\"${alt}\""
  echo "    loading=\"lazy\""
  echo "    decoding=\"async\""
  echo "    class=\"img-fluid\""
  echo "  >"
  echo "</picture>"

  # Thumbnail snippet
  if [ "$THUMB_SIZE" -gt 0 ]; then
    echo ""
    echo "<!-- Thumbnail -->"
    echo "<img src=\"${base}/thumb/${name}-thumb-${THUMB_SIZE}.${ext}\" alt=\"${alt} thumbnail\" loading=\"lazy\" class=\"img-thumbnail\">"
  fi
}


generate_html_snippet() {
  local snippet
  snippet=$(build_html_snippet "$1" "$2" "$3")

  [ "$QUIET" = false ] && echo -e "${BLUE}--- HTML Snippet ---${NC}\n${snippet}\n"

  if [[ -n "$SNIPPET_OUT" ]]; then
    mkdir -p "$(dirname "$SNIPPET_OUT")"
    echo "$snippet" > "$SNIPPET_OUT"
    echo -e "${GREEN}✔ Snippet written to $SNIPPET_OUT${NC}"
  fi
}


# ============================================================
# MAIN PROCESSOR
# ============================================================
process_image() {
  local img=$(normalize_path "$1")
  local filename name ext outdir
  filename=$(basename "$img")
  name="${filename%.*}"
  ext="${filename##*.}"
  # Always write optimized variants under public/uploads/optimized/<name>
  outdir="public/uploads/optimized/$name"

  mkdir -p "$outdir"

  [ "$QUIET" = false ] && echo -e "\n${BLUE}=== Processing: $filename ===${NC}"

  # MOBILE ONLY?
  if [ "$MOBILE_ONLY" = true ]; then
    generate_mobile_crop "$img" "$name" "$ext" "$outdir"
    generate_html_snippet "$name" "$ext" "$outdir"
    return
  fi

  # THUMB ONLY?
  if [ "$THUMB_ONLY" = true ]; then
    generate_thumbnail "$img" "$name" "$ext" "$outdir"
    return
  fi

  # MAIN SIZES
  for size in "${SIZES[@]}"; do
    local jpg="$outdir/${name}-${size}.${ext}"
    local webp="$outdir/${name}-${size}.webp"

    # JPG
    if [ "$GENERATE_JPG" = true ]; then
      if [[ ! -f "$jpg" || "$FORCE" = true ]]; then
        resize_jpg "$img" "$size" "$jpg"
        [ "$QUIET" = false ] && echo -e "  ${GREEN}✔ JPG ${size}px created${NC}"
      fi
    fi

    # WebP
    if [ "$GENERATE_WEBP" = true ]; then
      if [[ ! -f "$webp" || "$FORCE" = true ]]; then
        resize_webp "$img" "$size" "$webp"
        [ "$QUIET" = false ] && echo -e "  ${GREEN}✔ WebP ${size}px created${NC}"
      fi
    fi
  done

  # THUMB
  if [ "$NO_THUMB" = false ] && [ "$THUMB_SIZE" -gt 0 ]; then
    generate_thumbnail "$img" "$name" "$ext" "$outdir"
  fi

  # MOBILE
  if [ "$MOBILE_SIZE" -gt 0 ]; then
    generate_mobile_crop "$img" "$name" "$ext" "$outdir"
  fi

  # HTML
  generate_html_snippet "$name" "$ext" "$outdir"

  [ "$QUIET" = false ] && echo -e "${GREEN}✔ Finished: $filename${NC}"
}


# ============================================================
# ENTRYPOINT
# ============================================================
TARGET="$1"

if [[ -z "$TARGET" ]]; then
  echo -e "${RED}❌ No file or directory provided.${NC}"
  exit 1
fi

TARGET=$(normalize_path "$TARGET")

if [[ -f "$TARGET" ]]; then
  process_image "$TARGET"

elif [[ -d "$TARGET" ]]; then
  shopt -s nullglob
  for f in "$TARGET"/*.{jpg,JPG,jpeg,JPEG,png,PNG}; do
    process_image "$f"
  done

else
  echo -e "${RED}❌ Invalid target: $TARGET${NC}"
  exit 1
fi


# --------------------------
# ./scripts/optimize-images.sh public/uploads/my-beautiful-ci-flame.jpg
# ./scripts/optimize-images.sh public/uploads/images
#  End of Script
# --------------------------

import os
import sys
import cv2
from mosaic import mosaic as mosaic

# 「〇〇.jpg」を引数として受け取る想定
args = sys.argv

# カスケードファイルを指定して分類器を作成
cascade_file = "haarcascade_frontalface_alt.xml"
cascade = cv2.CascadeClassifier(cascade_file)

# 画像を読み込んでグレイスケールに変換
img = cv2.imread("mosbefore\\" + args[1])
img_gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)

# 顔検出を実行
face_list = cascade.detectMultiScale(img_gray, minSize=(150, 150))

# 認識した部分の画像にモザイクをかける
for (x,y,w,h) in face_list:
    img = mosaic(img, (x, y, x+w, y+h), 10)

# 画像を出力
image_name = os.path.splitext(os.path.basename(args[1]))[0]  #画像名だけ抜き出し
cv2.imwrite("mosafter\\" + image_name + ".jpg", img)
# plt.axis('off')
# plt.imshow(cv2.cvtColor(img, cv2.COLOR_BGR2RGB))
# plt.show()
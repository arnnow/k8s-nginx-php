FROM debian:buster
RUN apt-get update \
&& apt-get install -y default-mysql-client \
&& apt-get install -y wget \
&& apt-get install -y bzip2 \
&& apt-get install -y dnsutils \
&& rm -rf /var/lib/apt/lists/*

# Copy Load script
COPY start.sh /start.sh
CMD ["./start.sh"]

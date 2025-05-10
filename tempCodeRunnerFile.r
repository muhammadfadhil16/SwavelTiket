import matplotlib.pyplot as plt
import numpy as np

# Define the x values for the plot
x = np.linspace(0, 5000, 500)

# Equations of the constraints
y1 = 4667 - x  # X1 + X2 = 4667
y2 = (250 / 0.6) - (x * (0 / 0.6))  # 0.6X1 + 0.6X2 = 250

# Feasibility check (both conditions)
y1 = np.clip(y1, 0, None)  # Non-negativity
y2 = np.clip(y2, 0, None)  # Non-negativity

# Points for axis intersections
points_x = [0, 4667, 416.67]
points_y = [4667, 0, 416.67]

# Plot the constraints
plt.figure(figsize=(10, 6))
plt.plot(x, y1, label="X1 + X2 = 4667", color="blue")
plt.plot(x, y2, label="0.6X1 + 0.6X2 = 250", color="green")

# Fill the feasible region
plt.fill_between(x, np.minimum(y1, y2), color="lightgrey", alpha=0.5, label="Feasible Region")

# Add axis labels and legend
plt.xlim(0, 5000)
plt.ylim(0, 5000)
plt.xlabel("X1 (Diameter 6 mm)")
plt.ylabel("X2 (Diameter 7 mm)")
plt.axhline(0, color='black',linewidth=0.5)
plt.axvline(0, color='black',linewidth=0.5)

# Annotating key points (intersections)
for px, py in zip(points_x, points_y):
    plt.scatter(px, py, color='red')
    plt.text(px, py + 100, f"({px:.2f}, {py:.2f})")

plt.legend()
plt.title("Feasible Region and Constraints (Graphical Method)")
plt.grid(True)

# Show the plot
plt.show()
